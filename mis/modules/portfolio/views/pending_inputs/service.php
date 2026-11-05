<?php

$getMemDetails = "select t1.id, t1.email, t1.inv_no, t2.partner_id from inv_user as t1 left join innovation_pool as t2 on t2.innovation_id = t1.inv_no";
$result = mysqli_query($getMemDetails);

$getIpitchUserDetails = "select t1.pitch_id as id, t1.email, t1.inno_id as inv_no, t2.partner_id from pitch_user as t1 left join innovation_pool as t2 on t2.innovation_id = t1.inno_id";
$ipitchResult = mysqli_query($getIpitchUserDetails);

$i = 0;
$main_email = array();
while ($row = mysqli_fetch_array($result)) {
    $get_inv[] = $row['inv_no'];
    $get_email = $row['email'];
    $sql_merge = array();

    $sql1 = "select subt.inv_user_id, invu.inv_no, invu.email from inv_member as subt LEFT JOIN inv_user as invu ON invu.id=subt.inv_user_id where subt.mem_email='$get_email' and subt.inv_user_id != 0";

    $sql2 = "select subt.pitch_id as inv_user_id, invu.inno_id as inv_no, invu.email from pitch_step1_members as subt LEFT JOIN pitch_user as invu ON invu.pitch_id=subt.pitch_id where subt.email='$get_email' and subt.pitch_id != 0";

    $query1 = mysqli_query($sql1);
    $query2 = mysqli_query($sql2);
    $sql_merge = php72_array_merge($query1, $query2);
    print_r($sql_merge);
    die;

    $num_rows = mysqli_num_rows($query);
    if ($num_rows != 0) {
        while ($fetch = mysqli_fetch_array($query)) {
            if ($fetch['email'] != $get_email) {
                if (array_key_exists($row['email'], $main_email)) {
                    $main_email[$row['email']] = $main_email[$row['email']] . ',' . "'" . $fetch['inv_no'] . "'";
                } else {
                    $main_email[$row['email']] = "'" . $fetch['inv_no'] . "'";
                }
            }
        }
    }
    if (array_key_exists($row['email'], $main_email)) {
        $main_email[$row['email']] = $main_email[$row['email']] . ',' . "'" . $row['inv_no'] . "'";
    } else {
        $main_email[$row['email']] = "'" . $row['inv_no'] . "'";
    }
}
while ($rowPitch = mysqli_fetch_array($ipitchResult)) {
    $get_inv[] = $rowPitch['inv_no'];
    $get_email = $rowPitch['email'];
    $sql = "select subt.pitch_id as inv_user_id, invu.inno_id as inv_no,'pitch' as inv_type, invu.email from pitch_step1_members as subt LEFT JOIN pitch_user as invu ON invu.pitch_id=subt.pitch_id where subt.email='$get_email' and subt.pitch_id != 0";
    $query = mysqli_query($sql);
    $num_rows = mysqli_num_rows($query);
    if ($num_rows != 0) {
        while ($fetch = mysqli_fetch_array($query)) {
            if ($fetch['email'] != $get_email) {
                if (array_key_exists($rowPitch['email'], $main_email)) {
                    $main_email[$rowPitch['email']]['inv_no'] = $main_email[$rowPitch['email']] . ',' . "'" . $fetch['inv_no'] . "'";
                } else {
                    $main_email[$rowPitch['email']]['inv_no'] = "'" . $fetch['inv_no'] . "'";
                }
            }
        }
    }
    if (array_key_exists($rowPitch['email'], $main_email)) {
        $main_email[$rowPitch['email']]['inv_no'] = $main_email[$rowPitch['email']] . ',' . "'" . $rowPitch['inv_no'] . "'";
    } else {
        $main_email[$rowPitch['email']]['inv_no'] = "'" . $rowPitch['inv_no'] . "'";
    }
}

$i = 1;
$user_id = array();
foreach ($main_email as $key => $value) {
    $sql = "select ipo.partner_id as partners_id, invu.id as invuser_id, ipo.innovation_id as pool_id from innovation_pool as ipo LEFT JOIN inv_user as invu ON invu.inv_no = ipo.innovation_id where ipo.innovation_id IN($value) and ipo.copy_status != '4' and ipo.status != '10' and ipo.status != '11' and ipo.program = '0' GROUP BY ipo.partner_id";
    $query = mysqli_query($sql);
    if (mysqli_num_rows($query) > 1) {
        while ($fetch = mysqli_fetch_array($query)) {
            if (array_key_exists($i, $user_id)) {
                $user_id[$i]['partner_id'] = $user_id[$i]['partner_id'] . "," . $fetch['partners_id'];
                $user_id[$i]['invuser_id'] = $user_id[$i]['invuser_id'] . "," . $fetch['invuser_id'];
                $user_id[$i]['pool_id'] = $user_id[$i]['pool_id'] . "," . $fetch['pool_id'];
            } else {
                $user_id[$i]['partner_id'] = $fetch['partners_id'];
                $user_id[$i]['invuser_id'] = $fetch['invuser_id'];
                $user_id[$i]['pool_id'] = $fetch['pool_id'];
            }
        }
        $i++;
    }
}

if (!empty($user_id)) {
    foreach ($user_id as $key => $value) {
        $invuser_id = explode(',', $value['invuser_id']);
        $pool_id = explode(',', $value['pool_id']);
        for ($i = 0; $i < count($pool_id); $i++) {
            $update_id = array();
            for ($j = 0; $j < count($invuser_id); $j++) {
                if ($i != $j) {
                    $update_id[] = $invuser_id[$j];
                }
            }
            $implodeid = implode(',', $update_id);
            $get_invid = $pool_id[$i];
            $update_query = "update innovation_pool set other_partner_id = '$implodeid' where innovation_id = '$get_invid'";
            mysqli_query($update_query) or die('Could not connect: ' . mysqli_error());
        }
    }
}