<?php
/**
 * PHPExcel 1.7.7 compatibility layer on top of PhpSpreadsheet (installed with Composer in /vendor).
 *
 * PHPExcel 1.7.7 does not run on PHP 8 (it uses $string{0} offsets, which are a compile error since PHP 8.0).
 * The controllers keep using the PHPExcel API unchanged; these classes give that API the same behaviour as
 * PHPExcel 1.7.7 had, but do the work with PhpSpreadsheet:
 *  - PHPExcel                 : a PhpSpreadsheet workbook whose sheets are PHPExcel_Worksheet objects.
 *  - PHPExcel_Worksheet       : adds the *ByColumnAndRow() methods with PHPExcel's 0-based column numbers
 *                               (PhpSpreadsheet counts columns from 1).
 *  - PHPExcel_Style           : accepts PHPExcel style arrays ('type', 'allborders', 'style', 'wrap', ...).
 *  - PHPExcel_Compat_ValueBinder : decides cell types exactly like PHPExcel 1.7.7's DefaultValueBinder.
 *  - PHPExcel_IOFactory       : maps 'Excel2007' / 'Excel5' / 'CSV' / 'HTML' to PhpSpreadsheet writers and readers.
 *  - PHPExcel_Compat_Read*    : wrappers for workbooks that were read from a file, so getCellCollection(),
 *                               setDataType() and getCalculatedValue() return what PHPExcel 1.7.7 returned.
 *  - PHPExcel_Style_*, PHPExcel_Cell_DataType : the same constants (values copied from PHPExcel 1.7.7).
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Cell\Cell as PsCell;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate as PsCoordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType as PsDataType;
use PhpOffice\PhpSpreadsheet\Cell\IValueBinder as PsValueBinder;
use PhpOffice\PhpSpreadsheet\IOFactory as PsIOFactory;
use PhpOffice\PhpSpreadsheet\RichText\RichText as PsRichText;
use PhpOffice\PhpSpreadsheet\Spreadsheet as PsSpreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Style as PsStyle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet as PsWorksheet;

/* ------------------------------------------------------------------ workbook */

class PHPExcel extends PsSpreadsheet
{
    /** @var PHPExcel_Style|null style supervisor that understands PHPExcel style arrays */
    private $compatStyleSupervisor = null;

    public function __construct()
    {
        parent::__construct();
        // Cell types are decided the way PHPExcel 1.7.7 decided them.
        $this->setValueBinder(new PHPExcel_Compat_ValueBinder());
        // Replace the default sheet with a PHPExcel_Worksheet (same title "Worksheet", still the active sheet).
        $this->removeSheetByIndex(0);
        $this->addSheet(new PHPExcel_Worksheet($this));
        $this->setActiveSheetIndex(0);
    }

    /** New sheets are PHPExcel_Worksheet objects too (PHPExcel 1.7.7 titled them "Worksheet 1", "Worksheet 2", ...). */
    public function createSheet(?int $sheetIndex = null): PsWorksheet
    {
        $newSheet = new PHPExcel_Worksheet($this);
        $this->addSheet($newSheet, $sheetIndex, true);
        return $newSheet;
    }

    /** getStyle() returns this supervisor, so applyFromArray() accepts PHPExcel style arrays. */
    public function getCellXfSupervisor(): PsStyle
    {
        if ($this->compatStyleSupervisor === null) {
            $this->compatStyleSupervisor = new PHPExcel_Style(true);
            $this->compatStyleSupervisor->bindParent($this);
        }
        return $this->compatStyleSupervisor;
    }
}

/* ----------------------------------------------------------------- worksheet */

class PHPExcel_Worksheet extends PsWorksheet
{
    // PHPExcel 1.7.7: setCellValue($pCoordinate, $pValue, $returnCell = false)
    public function setCellValueByColumnAndRow($pColumn = 0, $pRow = 1, $pValue = null, $returnCell = false)
    {
        $cell = $this->getCell(PHPExcel_Cell::stringFromColumnIndex($pColumn) . $pRow);
        $cell->setValue($pValue);
        return $returnCell ? $cell : $this;
    }

    public function setCellValueExplicitByColumnAndRow($pColumn = 0, $pRow = 1, $pValue = null, $pDataType = PHPExcel_Cell_DataType::TYPE_STRING)
    {
        return $this->setCellValueExplicit(PHPExcel_Cell::stringFromColumnIndex($pColumn) . $pRow, $pValue, $pDataType);
    }

    public function getCellByColumnAndRow($pColumn = 0, $pRow = 1)
    {
        return $this->getCell(PHPExcel_Cell::stringFromColumnIndex($pColumn) . $pRow);
    }

    public function getStyleByColumnAndRow($pColumn = 0, $pRow = 1)
    {
        return $this->getStyle(PHPExcel_Cell::stringFromColumnIndex($pColumn) . $pRow);
    }

    /** PHPExcel 1.7.7 created every cell of a merged range (hidden cells empty); PhpSpreadsheet only the upper-left one. */
    public function mergeCells(\PhpOffice\PhpSpreadsheet\Cell\AddressRange|string|array $range, string $behaviour = self::MERGE_CELL_CONTENT_EMPTY): static
    {
        parent::mergeCells($range, $behaviour);
        if (is_string($range) && strpos($range, ':') !== false) {
            $refs = PsCoordinate::extractAllCellReferencesInRange(strtoupper($range));
            foreach ($refs as $i => $coord) {
                if ($i > 0 || !$this->cellExists($coord)) {
                    $this->getCell($coord)->setValueExplicit(null, PsDataType::TYPE_NULL);
                }
            }
        }
        return $this;
    }

    public function mergeCellsByColumnAndRow($pColumn1 = 0, $pRow1 = 1, $pColumn2 = 0, $pRow2 = 1)
    {
        return $this->mergeCells(PHPExcel_Cell::stringFromColumnIndex($pColumn1) . $pRow1 . ':' . PHPExcel_Cell::stringFromColumnIndex($pColumn2) . $pRow2);
    }
}

/* --------------------------------------------------------------------- style */

class PHPExcel_Style extends PsStyle
{
    public function applyFromArray(array $styleArray, bool $advancedBorders = true): static
    {
        $styleArray = PHPExcel_Compat::styleArray($styleArray);
        if (!$this->isSupervisor) {
            return parent::applyFromArray($styleArray, $advancedBorders);
        }
        $sheet = $this->getActiveSheet();
        $range = strtoupper(str_replace('$', '', $this->getSelectedCells()));

        if (preg_match('/^[A-Z]+1:[A-Z]+1048576$/', $range) || preg_match('/^A\d+:XFD\d+$/', $range)) {
            // Whole column / whole row: PHPExcel 1.7.7 styled only the column or row itself; cells that
            // already existed kept their style (PhpSpreadsheet also restyles them).
            list($start, $end) = PsCoordinate::rangeBoundaries($range);
            $saved = array();
            foreach ($sheet->getCoordinates(false) as $coord) {
                list($col, $row) = PsCoordinate::indexesFromString($coord);
                if ($col >= $start[0] && $col <= $end[0] && $row >= $start[1] && $row <= $end[1]) {
                    $saved[$coord] = $sheet->getCell($coord)->getXfIndex();
                }
            }
            parent::applyFromArray($styleArray, $advancedBorders);
            foreach ($saved as $coord => $xf) {
                $sheet->getCell($coord)->setXfIndex($xf);
            }
            $sheet->setSelectedCells($range);
            return $this;
        }

        // Cell range: PHPExcel 1.7.7 created missing cells with the default style (getCellByColumnAndRow),
        // not with the row / column style (PhpSpreadsheet's getCell() takes the row / column style).
        list($start, $end) = PsCoordinate::rangeBoundaries(strpos($range, ':') === false ? "$range:$range" : $range);
        for ($col = $start[0]; $col <= $end[0]; ++$col) {
            for ($row = $start[1]; $row <= $end[1]; ++$row) {
                if (!$sheet->cellExists(array($col, $row))) {
                    $sheet->getCell(array($col, $row))->setXfIndex(0);
                }
            }
        }
        return parent::applyFromArray($styleArray, $advancedBorders);
    }
}

class PHPExcel_Compat
{
    /** Rename PHPExcel 1.7.7 style-array keys to the PhpSpreadsheet names (keys that are already new are kept). */
    public static function styleArray(array $s)
    {
        if (isset($s['numberformat']) && !isset($s['numberFormat'])) {
            $s['numberFormat'] = $s['numberformat'];
            unset($s['numberformat']);
        }
        if (isset($s['numberFormat']) && is_array($s['numberFormat'])) {
            $s['numberFormat'] = self::rename($s['numberFormat'], array('code' => 'formatCode'));
        }
        if (isset($s['fill']) && is_array($s['fill'])) {
            // PHPExcel 'color' set only the start colour (PhpSpreadsheet's 'color' sets start and end colour).
            $s['fill'] = self::rename($s['fill'], array('type' => 'fillType', 'color' => 'startColor', 'startcolor' => 'startColor', 'endcolor' => 'endColor'));
        }
        if (isset($s['font']) && is_array($s['font'])) {
            $s['font'] = self::rename($s['font'], array('strike' => 'strikethrough', 'superScript' => 'superscript', 'subScript' => 'subscript'));
        }
        if (isset($s['alignment']) && is_array($s['alignment'])) {
            $s['alignment'] = self::rename($s['alignment'], array('wrap' => 'wrapText', 'rotation' => 'textRotation'));
        }
        if (isset($s['borders']) && is_array($s['borders'])) {
            $b = self::rename($s['borders'], array('allborders' => 'allBorders', 'diagonaldirection' => 'diagonalDirection'));
            foreach (array('allBorders', 'outline', 'inside', 'vertical', 'horizontal', 'left', 'right', 'top', 'bottom', 'diagonal') as $side) {
                if (isset($b[$side]) && is_array($b[$side])) {
                    $b[$side] = self::rename($b[$side], array('style' => 'borderStyle'));
                }
            }
            $s['borders'] = $b;
        }
        return $s;
    }

    private static function rename(array $a, array $map)
    {
        $out = array();
        foreach ($a as $k => $v) {
            $out[(is_string($k) && isset($map[$k])) ? $map[$k] : $k] = $v;
        }
        return $out;
    }

    /** PHPExcel_Shared_String::SanitizeUTF8() */
    public static function sanitizeUTF8($value)
    {
        if (function_exists('iconv')) {
            return @iconv('UTF-8', 'UTF-8', $value);
        }
        if (function_exists('mb_convert_encoding')) {
            return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
        }
        return $value;
    }
}

/* -------------------------------------------------------------- value binder */

/** Same type decisions and value conversions as PHPExcel 1.7.7 PHPExcel_Cell_DefaultValueBinder + setValueExplicit(). */
class PHPExcel_Compat_ValueBinder implements PsValueBinder
{
    public function bindValue(PsCell $cell, mixed $value): bool
    {
        if (is_string($value)) {
            $value = PHPExcel_Compat::sanitizeUTF8($value);
        }
        $type = self::dataTypeForValue($value);
        switch ($type) {
            case PHPExcel_Cell_DataType::TYPE_NUMERIC:
                // PHPExcel stored (float) and wrote it as text with PHP precision 16 ("3", "9880459843", "1.5",
                // "8.976148648701426E+19"). PhpSpreadsheet writes floats as "3.0", so whole numbers that precision 16
                // prints as plain digits (below 1e16) are stored as int; other floats are written during save()
                // with precision 16 (see PHPExcel_Compat_Writer).
                $f = (float) $value;
                $isWhole = is_finite($f) && floor($f) == $f && abs($f) < 1e16 && (string) $f !== '-0';
                $cell->setValueExplicit($isWhole ? (int) $f : $f, PsDataType::TYPE_NUMERIC);
                break;
            case PHPExcel_Cell_DataType::TYPE_FORMULA:
                $cell->setValueExplicit((string) $value, PsDataType::TYPE_FORMULA);
                break;
            case PHPExcel_Cell_DataType::TYPE_BOOL:
                $cell->setValueExplicit((bool) $value, PsDataType::TYPE_BOOL);
                break;
            case PHPExcel_Cell_DataType::TYPE_ERROR:
                $cell->setValueExplicit((string) $value, PsDataType::TYPE_ERROR);
                break;
            case PHPExcel_Cell_DataType::TYPE_NULL:
                $cell->setValueExplicit(null, PsDataType::TYPE_NULL);
                break;
            case PHPExcel_Cell_DataType::TYPE_INLINE:
                $cell->setValueExplicit($value, PsDataType::TYPE_INLINE);
                break;
            default:
                $cell->setValueExplicit($value, PsDataType::TYPE_STRING);
        }
        return true;
    }

    public static function dataTypeForValue($pValue = null)
    {
        if (is_null($pValue)) {
            return PHPExcel_Cell_DataType::TYPE_NULL;
        } elseif ($pValue === '') {
            return PHPExcel_Cell_DataType::TYPE_STRING;
        } elseif ($pValue instanceof PsRichText) {
            return PHPExcel_Cell_DataType::TYPE_INLINE;
        } elseif (is_string($pValue) && $pValue[0] === '=' && strlen($pValue) > 1) {
            return PHPExcel_Cell_DataType::TYPE_FORMULA;
        } elseif (is_bool($pValue)) {
            return PHPExcel_Cell_DataType::TYPE_BOOL;
        } elseif (is_float($pValue) || is_int($pValue)) {
            return PHPExcel_Cell_DataType::TYPE_NUMERIC;
        } elseif (preg_match('/^\-?([0-9]+\\.?[0-9]*|[0-9]*\\.?[0-9]+)$/', (string) $pValue)) {
            return PHPExcel_Cell_DataType::TYPE_NUMERIC;
        } elseif (is_string($pValue) && array_key_exists($pValue, PHPExcel_Cell_DataType::getErrorCodes())) {
            return PHPExcel_Cell_DataType::TYPE_ERROR;
        }
        return PHPExcel_Cell_DataType::TYPE_STRING;
    }
}

/* ------------------------------------------------------------------ IOFactory */

class PHPExcel_IOFactory
{
    private static $types = array('Excel2007' => 'Xlsx', 'Excel5' => 'Xls', 'Excel2003XML' => 'Xml', 'OOCalc' => 'Ods',
        'SYLK' => 'Slk', 'Gnumeric' => 'Gnumeric', 'CSV' => 'Csv', 'HTML' => 'Html');

    private static function type($type)
    {
        return isset(self::$types[$type]) ? self::$types[$type] : $type;
    }

    public static function createWriter($objPHPExcel, $writerType = '')
    {
        return new PHPExcel_Compat_Writer(PsIOFactory::createWriter($objPHPExcel, self::type($writerType)));
    }

    public static function createReader($readerType = '')
    {
        return new PHPExcel_Compat_Reader(PsIOFactory::createReader(self::type($readerType)));
    }

    public static function load($pFilename)
    {
        return new PHPExcel_Compat_ReadWorkbook(PsIOFactory::load($pFilename));
    }

    public static function identify($pFilename)
    {
        $type = PsIOFactory::identify($pFilename);
        $back = array_flip(self::$types);
        return isset($back[$type]) ? $back[$type] : $type;
    }
}

/* ------------------------------------------- wrappers for workbooks read from a file */

/** Forwards every call to the wrapped object and wraps returned workbooks / sheets / cells. */
abstract class PHPExcel_Compat_Proxy
{
    protected $inner;

    public function __construct($inner)
    {
        $this->inner = $inner;
    }

    public function getInnerObject()
    {
        return $this->inner;
    }

    public function __call($name, $args)
    {
        return PHPExcel_Compat_Proxy::wrap(call_user_func_array(array($this->inner, $name), $args), $this);
    }

    public static function wrap($result, $self = null)
    {
        if ($self !== null && $result === $self->inner) {
            return $self;
        }
        if ($result instanceof PsSpreadsheet && !($result instanceof PHPExcel)) {
            return new PHPExcel_Compat_ReadWorkbook($result);
        }
        if ($result instanceof PsWorksheet && !($result instanceof PHPExcel_Worksheet)) {
            return PHPExcel_Compat_ReadSheet::of($result);
        }
        if ($result instanceof PsCell) {
            return new PHPExcel_Compat_ReadCell($result);
        }
        if ($result instanceof \PhpOffice\PhpSpreadsheet\Worksheet\RowIterator || $result instanceof \PhpOffice\PhpSpreadsheet\Worksheet\Row
            || $result instanceof \PhpOffice\PhpSpreadsheet\Worksheet\CellIterator) {
            return new PHPExcel_Compat_ReadIterator($result);
        }
        return $result;
    }
}

class PHPExcel_Compat_Reader extends PHPExcel_Compat_Proxy
{
}

/**
 * PHPExcel 1.7.7 started its calculation engine inside save(), and the engine raised PHP's 'precision' setting to 16
 * (64-bit PHP) for the rest of the request, so numbers were written with 16 significant digits. Same here.
 */
class PHPExcel_Compat_Writer extends PHPExcel_Compat_Proxy
{
    public function save($pFilename = null)
    {
        $setPrecision = (PHP_INT_SIZE == 4) ? 12 : 16;
        if (ini_get('precision') < $setPrecision) {
            ini_set('precision', $setPrecision);
        }
        $this->inner->save($pFilename);
    }
}

class PHPExcel_Compat_ReadWorkbook extends PHPExcel_Compat_Proxy
{
}

class PHPExcel_Compat_ReadSheet extends PHPExcel_Compat_Proxy
{
    public static function of(PsWorksheet $sheet)
    {
        static $cache;
        if ($cache === null) {
            $cache = new WeakMap();
        }
        if (!isset($cache[$sheet])) {
            $cache[$sheet] = new PHPExcel_Compat_ReadSheet($sheet);
        }
        return $cache[$sheet];
    }

    /** PHPExcel 1.7.7: list of cell coordinates; sorted by row, then column (CacheBase::getSortedCellList). */
    public function getCellCollection($pSorted = true)
    {
        $list = $this->inner->getCoordinates(false);
        if (!$pSorted) {
            return $list;
        }
        $sortKeys = array();
        foreach ($list as $coord) {
            list($column, $row) = sscanf($coord, '%[A-Z]%d');
            $sortKeys[sprintf('%09d%3s', $row, $column)] = $coord;
        }
        ksort($sortKeys);
        return array_values($sortKeys);
    }

    public function getCellByColumnAndRow($pColumn = 0, $pRow = 1)
    {
        return $this->getCell(PHPExcel_Cell::stringFromColumnIndex($pColumn) . $pRow);
    }

    public function getStyleByColumnAndRow($pColumn = 0, $pRow = 1)
    {
        return $this->inner->getStyle(PHPExcel_Cell::stringFromColumnIndex($pColumn) . $pRow);
    }
}

/** Row iterator, row and cell iterator: iterate like the original and wrap what they yield. */
class PHPExcel_Compat_ReadIterator extends PHPExcel_Compat_Proxy implements Iterator
{
    public function current(): mixed
    {
        return PHPExcel_Compat_Proxy::wrap($this->inner->current());
    }

    public function key(): mixed
    {
        return $this->inner->key();
    }

    public function next(): void
    {
        $this->inner->next();
    }

    public function rewind(): void
    {
        $this->inner->rewind();
    }

    public function valid(): bool
    {
        return $this->inner->valid();
    }
}

/**
 * PHPExcel 1.7.7 setDataType() only changed the type; the value stayed as read (PhpSpreadsheet converts the value).
 * getCalculatedValue() then returned the stored value unless the type was a formula.
 */
class PHPExcel_Compat_ReadCell extends PHPExcel_Compat_Proxy
{
    private $dataType = null;

    public function setDataType($pDataType = PHPExcel_Cell_DataType::TYPE_STRING)
    {
        if ($pDataType == PHPExcel_Cell_DataType::TYPE_STRING2) {
            $pDataType = PHPExcel_Cell_DataType::TYPE_STRING;
        }
        $this->dataType = $pDataType;
        return $this;
    }

    public function getDataType()
    {
        return $this->dataType !== null ? $this->dataType : $this->inner->getDataType();
    }

    public function getCalculatedValue($resetLog = true)
    {
        if ($this->dataType !== null && $this->dataType !== PHPExcel_Cell_DataType::TYPE_FORMULA) {
            return self::number($this->inner->getValue());
        }
        if ($this->dataType === PHPExcel_Cell_DataType::TYPE_FORMULA && !$this->inner->isFormula()) {
            return self::number($this->inner->getValue());
        }
        return self::number($this->inner->getCalculatedValue($resetLog));
    }

    /** PHPExcel 1.7.7 readers returned every number as float (PhpSpreadsheet returns whole numbers as int). */
    public function getValue()
    {
        return self::number($this->inner->getValue());
    }

    /** PHPExcel 1.7.7 returned the row number as a string (it came from the coordinate text). */
    public function getRow()
    {
        return (string) $this->inner->getRow();
    }

    private static function number($v)
    {
        return is_int($v) ? (float) $v : $v;
    }
}

/* ------------------------------------------------------------- static helpers */

class PHPExcel_Cell
{
    /** PHPExcel 1.7.7: 0 => 'A', 25 => 'Z', 26 => 'AA' (0-based). */
    public static function stringFromColumnIndex($pColumnIndex = 0)
    {
        return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex((int) $pColumnIndex + 1);
    }

    /** PHPExcel 1.7.7: 'A' => 1 (1-based, same as PhpSpreadsheet). */
    public static function columnIndexFromString($pString = 'A')
    {
        return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($pString);
    }
}

/* ------------------------------------- constants (values copied from PHPExcel 1.7.7) */

class PHPExcel_Style_Fill
{
    const FILL_NONE = 'none';
    const FILL_SOLID = 'solid';
    const FILL_GRADIENT_LINEAR = 'linear';
    const FILL_GRADIENT_PATH = 'path';
    const FILL_PATTERN_DARKDOWN = 'darkDown';
    const FILL_PATTERN_DARKGRAY = 'darkGray';
    const FILL_PATTERN_DARKGRID = 'darkGrid';
    const FILL_PATTERN_DARKHORIZONTAL = 'darkHorizontal';
    const FILL_PATTERN_DARKTRELLIS = 'darkTrellis';
    const FILL_PATTERN_DARKUP = 'darkUp';
    const FILL_PATTERN_DARKVERTICAL = 'darkVertical';
    const FILL_PATTERN_GRAY0625 = 'gray0625';
    const FILL_PATTERN_GRAY125 = 'gray125';
    const FILL_PATTERN_LIGHTDOWN = 'lightDown';
    const FILL_PATTERN_LIGHTGRAY = 'lightGray';
    const FILL_PATTERN_LIGHTGRID = 'lightGrid';
    const FILL_PATTERN_LIGHTHORIZONTAL = 'lightHorizontal';
    const FILL_PATTERN_LIGHTTRELLIS = 'lightTrellis';
    const FILL_PATTERN_LIGHTUP = 'lightUp';
    const FILL_PATTERN_LIGHTVERTICAL = 'lightVertical';
    const FILL_PATTERN_MEDIUMGRAY = 'mediumGray';
}

class PHPExcel_Style_Border
{
    const BORDER_NONE = 'none';
    const BORDER_DASHDOT = 'dashDot';
    const BORDER_DASHDOTDOT = 'dashDotDot';
    const BORDER_DASHED = 'dashed';
    const BORDER_DOTTED = 'dotted';
    const BORDER_DOUBLE = 'double';
    const BORDER_HAIR = 'hair';
    const BORDER_MEDIUM = 'medium';
    const BORDER_MEDIUMDASHDOT = 'mediumDashDot';
    const BORDER_MEDIUMDASHDOTDOT = 'mediumDashDotDot';
    const BORDER_MEDIUMDASHED = 'mediumDashed';
    const BORDER_SLANTDASHDOT = 'slantDashDot';
    const BORDER_THICK = 'thick';
    const BORDER_THIN = 'thin';
}

class PHPExcel_Style_Alignment
{
    const HORIZONTAL_GENERAL = 'general';
    const HORIZONTAL_LEFT = 'left';
    const HORIZONTAL_RIGHT = 'right';
    const HORIZONTAL_CENTER = 'center';
    const HORIZONTAL_CENTER_CONTINUOUS = 'centerContinuous';
    const HORIZONTAL_JUSTIFY = 'justify';
    const VERTICAL_BOTTOM = 'bottom';
    const VERTICAL_TOP = 'top';
    const VERTICAL_CENTER = 'center';
    const VERTICAL_JUSTIFY = 'justify';
}

class PHPExcel_Style_Font
{
    const UNDERLINE_NONE = 'none';
    const UNDERLINE_DOUBLE = 'double';
    const UNDERLINE_DOUBLEACCOUNTING = 'doubleAccounting';
    const UNDERLINE_SINGLE = 'single';
    const UNDERLINE_SINGLEACCOUNTING = 'singleAccounting';
}

class PHPExcel_Style_Color
{
    const COLOR_BLACK = 'FF000000';
    const COLOR_WHITE = 'FFFFFFFF';
    const COLOR_RED = 'FFFF0000';
    const COLOR_DARKRED = 'FF800000';
    const COLOR_BLUE = 'FF0000FF';
    const COLOR_DARKBLUE = 'FF000080';
    const COLOR_GREEN = 'FF00FF00';
    const COLOR_DARKGREEN = 'FF008000';
    const COLOR_YELLOW = 'FFFFFF00';
    const COLOR_DARKYELLOW = 'FF808000';
}

class PHPExcel_Style_NumberFormat
{
    const FORMAT_GENERAL = 'General';
    const FORMAT_TEXT = '@';
    const FORMAT_NUMBER = '0';
    const FORMAT_NUMBER_00 = '0.00';
    const FORMAT_NUMBER_COMMA_SEPARATED1 = '#,##0.00';
    const FORMAT_NUMBER_COMMA_SEPARATED2 = '#,##0.00_-';
    const FORMAT_PERCENTAGE = '0%';
    const FORMAT_PERCENTAGE_00 = '0.00%';
    const FORMAT_DATE_YYYYMMDD2 = 'yyyy-mm-dd';
    const FORMAT_DATE_YYYYMMDD = 'yy-mm-dd';
    const FORMAT_DATE_DDMMYYYY = 'dd/mm/yy';
    const FORMAT_DATE_DMYSLASH = 'd/m/y';
    const FORMAT_DATE_DMYMINUS = 'd-m-y';
    const FORMAT_DATE_DMMINUS = 'd-m';
    const FORMAT_DATE_MYMINUS = 'm-y';
    const FORMAT_DATE_XLSX14 = 'mm-dd-yy';
    const FORMAT_DATE_XLSX15 = 'd-mmm-yy';
    const FORMAT_DATE_XLSX16 = 'd-mmm';
    const FORMAT_DATE_XLSX17 = 'mmm-yy';
    const FORMAT_DATE_XLSX22 = 'm/d/yy h:mm';
    const FORMAT_DATE_DATETIME = 'd/m/y h:mm';
    const FORMAT_DATE_TIME1 = 'h:mm AM/PM';
    const FORMAT_DATE_TIME2 = 'h:mm:ss AM/PM';
    const FORMAT_DATE_TIME3 = 'h:mm';
    const FORMAT_DATE_TIME4 = 'h:mm:ss';
    const FORMAT_DATE_TIME5 = 'mm:ss';
    const FORMAT_DATE_TIME6 = 'h:mm:ss';
    const FORMAT_DATE_TIME7 = 'i:s.S';
    const FORMAT_DATE_TIME8 = 'h:mm:ss;@';
    const FORMAT_DATE_YYYYMMDDSLASH = 'yy/mm/dd;@';
    const FORMAT_CURRENCY_USD_SIMPLE = '"$"#,##0.00_-';
    const FORMAT_CURRENCY_USD = '$#,##0_-';
    const FORMAT_CURRENCY_EUR_SIMPLE = '[$EUR ]#,##0.00_-';
}

class PHPExcel_Style_Protection
{
    const PROTECTION_INHERIT = 'inherit';
    const PROTECTION_PROTECTED = 'protected';
    const PROTECTION_UNPROTECTED = 'unprotected';
}

class PHPExcel_Cell_DataType
{
    public static function getErrorCodes()
    {
        return array('#NULL!' => 0, '#DIV/0!' => 1, '#VALUE!' => 2, '#REF!' => 3, '#NAME?' => 4, '#NUM!' => 5, '#N/A' => 6);
    }

    const TYPE_STRING2 = 'str';
    const TYPE_STRING = 's';
    const TYPE_FORMULA = 'f';
    const TYPE_NUMERIC = 'n';
    const TYPE_BOOL = 'b';
    const TYPE_NULL = 'null';
    const TYPE_INLINE = 'inlineStr';
    const TYPE_ERROR = 'e';
}
