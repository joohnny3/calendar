<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./image/calendar.png" type="image/png">
    <title>張董事長的Calendar</title>
    <link rel="stylesheet" href="./calendar.css">
</head>

<body>
    <?php
    date_default_timezone_set('Asia/Taipei');
    $month = $_GET['month'] ?? date("n");
    $year = $_GET['year'] ?? date("Y");
    $firstDateTime = strtotime("$year-$month-1");
    $days = date("t", $firstDateTime);
    $finalDateTime = strtotime("$year-$month-$days");
    $firstDateWeek = date("w", $firstDateTime);
    $finalDateWeek = date("w", $finalDateTime);
    $weeks = ceil(($days + $firstDateWeek) / 7);
    // $firstWeekSpace=$firstDateWeek-1;       //計算當前月份第一周的空白日(或前一個月份佔幾天)
    $days = [];
    for ($i = 0; $i < $weeks; $i++) {
        for ($j = 0; $j < 7; $j++) {
            if (($i == 0 && $j < $firstDateWeek) || (($i == $weeks - 1) && $j > $finalDateWeek)) {
                $days[] = '&nbsp;';
            } else {
                $num = ($j + 7 * $i - ($firstDateWeek - 1));
                $days[] = $year . "-" . $month . "-" . $num;
            }
        }
    }
    if ($month == 1) {
        $prevYear = $year - 1;
        $prevMonth = 12;
    } else {
        $prevYear = $year;
        $prevMonth = $month - 1;
    }
    if ($month == 12) {
        $nextYear = $year + 1;
        $nextMonth = 1;
    } else {
        $nextYear = $year;
        $nextMonth = $month + 1;
    }
    $monthM = date("M", strtotime("$year-$month"));
    ?>

    <div class="top">
        <div class="month"><?= $monthM; ?></div>
        <div class="year">&nbsp;<?= $year; ?> </div>
    </div>

    <div>
        <a class="left" href="?year=<?= $prevYear; ?>&month=<?= $prevMonth; ?>"><img src="./image/NEWnextL.png" alt="" width="40px"></a>
        <a class="right" href="?year=<?= $nextYear; ?>&month=<?= $nextMonth; ?>"><img src="./image/NEWnextR.png" alt="" width="40px"></a>
    </div>

    <div class='calendar'>
        <div class="week">Sun</div>
        <div class="week">Mon</div>
        <div class="week">Tue</div>
        <div class="week">Wed</div>
        <div class="week">Thu</div>
        <div class="week">Fri</div>
        <div class="week">Sat</div>
        <?php
        for ($i = 0; $i < count($days); $i++) {
            $today = date("Y-n-j");
            $d = ($days[$i] != '&nbsp;') ? explode('-', $days[$i])[2] : '&nbsp;';
            $h = ($days[$i] != '&nbsp;') ? explode('-', $days[$i])[2] . "h" : "";
            if ($today == $days[$i]) {

                if (isset($holiday[$days[$i]])) {

                    echo "<div class='today'> {$d}";
                    echo "  <div>";
                    echo $holiday[$days[$i]];
                    echo "  </div>";
                    echo "</div>";
                } else {
                    echo "<div class='today'> {$d} </div>";
                }

            } else {
                print "<div class='d$month$h'> {$d} </div>";
            }
        }
        ?>
    </div>

</body>

</html>