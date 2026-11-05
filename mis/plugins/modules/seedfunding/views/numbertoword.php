<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head><title>Number to word conversion - 4umi useful Javascript</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<meta name="description" content="How to write out numbers into words"/>
<meta http-equiv="content-script-type" content="text/javascript"/>

</head><body>

<fieldset style="display:none;">
<input type="checkbox" onclick="update();" id="comma" name="comma"/>
<input type="checkbox" onclick="update();" id="wrapx" name="wrapx" checked="checked"/>
</fieldset>

<div class="sam eva" style="display:none"><pre>
<script>
var ones = new Array(
 '',
 ' one',
 ' two',
 ' three',
 ' four',
 ' five',
 ' six',
 ' seven',
 ' eight',
 ' nine',
 ' ten',
 ' eleven',
 ' twelve',
 ' thirteen',
 ' fourteen',
 ' fifteen',
 ' sixteen',
 ' seventeen',
 ' eighteen',
 ' nineteen'
);

var tens = new Array(
 '',
 '',
 ' twenty',
 ' thirty',
 ' forty',
 ' fifty',
 ' sixty',
 ' seventy',
 ' eighty',
 ' ninety'
);

var triplets = new Array(
 '',
 ' thousand',
 ' million',
 ' billion',
 ' trillion',
 ' quadrillion',
 ' quintillion',
 ' sextillion',
 ' septillion',
 ' octillion',
 ' nonillion'
);

function convertTri(num, tri) {
 var str = '', comma = '',
  r = Math.round( ( num / 1000 ) - 0.5 ),
  x = Math.round( ( num / 100 ) - 0.5 ) % 10,
  y = Math.round( ( num % 100 ) - 0.5 );
 if(x &gt; 0) { // hundreds
  str = ones[x] + ' hundred';
 }
 if(y &lt; 20) { // ones and tens
  str += ones[y];
 } else {
  str += tens[Math.round( (y / 10) - 0.5 )] + ones[y % 10];
 }
 if(str) { // thousands
  str += triplets[tri];
 }
 if(r &gt; 0) { // continue recursing?
  if(str) {
   var f = document.forms.f;
   comma += f.comma.checked ? ',' : '';
   comma += f.wrapx.checked ? '&lt;br /&gt;' : '';
  }
  return convertTri( r, tri + 1 ) + comma + str;
 }
 return str;
}

function update() {
 var f = document.forms.f.elements, num = f.number.value, number, flip = 1, txt, t;
 if(!num) { return; }
 while( ( num.charAt()==' ' || num.charAt()=='0' ) &amp;&amp; num.length&gt;1 ) {
  num = num.substring(1);
  if( num.charAt()=='-' ) { flip *= -1; num = num.substring(1); }
 }
 num = num.replace( /[^0-9/.]/g, '' );
 number = parseInt( num, 10 );
 t = number ? ( ( flip&lt;0 ? 'minus' : '' ) + convertTri( number, 0 ) + (f.comma.checked ? '.' : '') ) :  'zero';

  c=num.split(".");
 if(c[1]>0)
 {
 	if(c[1].length<=1)
	c[1]=c[1]+'0';
 	t=t+" &amp; cents "+ convertTri( c[1], 0 );
 }	
 
 
 txt = t ? ( t.big().bold() ) : 'not a number.';
 document.getElementById('word').innerHTML =
  txt 
 document.getElementById('word').innerHTML;
}

function eva(o) {
 document.forms.f.elements.number.value =
  eval( document.forms.f.elements.number.value + o.value );
 update();
}

function upfont() {
 var f = document.forms.f.elements;
 gid('word').className = f.fontx.checked ? 'serif' : 'sans';
 f.number.focus();
}

ran( window.location.hash || '' );

</script>
</pre></div>

</body></html>