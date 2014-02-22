<?php

$function = isset($_GET["function"]) ? $_GET['function'] : '';
$course_id = isset($_GET["course"]) ? $_GET['course'] : '';
$classroom_id = isset($_GET["classroom_id"]) ? $_GET['classroom_id'] : '';
$months_to_show = isset($_GET["months"]) ? $_GET["months"] : 3;
$error = null;
$success = null;

if ( ! empty($classroom_id)) {
  $bookings = get_room_by_id($classroom_id);
}

?>

<div class="right">

  <?php if (isset($months_to_show) && $months_to_show > 0) { ?>

    <h3>Tider för klassrum</h3>

    <div id="calendar">
    <?php
      $months = 3;
      $todays_date = time();
      $year = date('Y', $todays_date);
      $month = date('m', $todays_date);
      $dates = array();
      $html = null;

      for ($current_month = 0; $current_month <= $months; $current_month++) {
        $month_calc = strtotime('+'.$current_month.' MONTH', $todays_date);
        $the_year = date('Y', $month_calc);
        $the_month = date('M', $month_calc);
        $the_monthnum = date('m', $month_calc);

        $dates[] = array(
          'year'  => $the_year,
          'month' => $the_month,
          'monthnum' => $the_monthnum
        );
      }

      // loop out the calendar dates
      foreach($dates as $date) {
        $html .= '<div class="month-container">';
        $html .= '<div class="month">'.$date['month'].' '.$date['year'].'</div>';
        $days_in_month = cal_days_in_month(CAL_GREGORIAN,$date['monthnum'], $date['year']);
        $html .= '<div class="days">';
        // loop out the calendar days
        for ($day = 1; $day <= $days_in_month; $day++) {
          $startdate = null;
          $enddate = null;
          $firstname = null;
          $lastname = null;
          $course_name = null;
          $the_day = $day;
          $booked_class = ' empty';

          if ($day < 10) {
            $the_day = '0'.$day;
          }

          foreach($bookings as $booking) {
            $current_loop_date = $date['year'].'-'.$date['monthnum'].'-'.$the_day;
            $booking_startdate = $booking['booking_startdate'];
            $booking_enddate = $booking['booking_enddate'];
            $bookingtime_start = $booking['bookingtime_start'];
            $bookingtime_end = $booking['bookingtime_end'];

            // check if current calendar date has a booking
            if ($current_loop_date >= $booking_startdate && $current_loop_date <= $booking_enddate) {
              $startdate = $booking_startdate;
              $enddate = $booking_enddate;
              $firstname = $booking['user_firstname'];
              $lastname = $booking['user_lastname'];
              !empty($booking['course_name']) ? $course_name = '#'.$booking['course_name'] : $course_name = null;

              // check if booking is full
              if ($bookingtime_start == '09:00:00' && $bookingtime_end == '16:00:00') {
                $booked_class = ' full';

              // check if booking is not full but has bookings
              } elseif ($bookingtime_start >= '09:00:00' && $bookingtime_end <= '16:00:00') {
                $booked_class = ' not-empty-not-full';
              }
              break;
            }
          }
          $html .= '<div class="day'.$booked_class.'" id="'.$date['year'].'-'.$date['monthnum'].'-'.$the_day.'"><span class="'.$startdate.' '.$enddate.' '.$firstname.' '.$lastname.' '.$course_name.'">'.$day.'</span></div>';
        }
        $html .= '</div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '</div>';
      }

      echo $html;
    ?>
      <?php /*
      // hämta bokningar som:
      // - har samma klassrum som det valda klassrummet
      // - inte redan har utgått
      $query = "SELECT * FROM tbl_booking LEFT JOIN tbl_user ON tbl_booking.user_id = tbl_user.user_id WHERE classroom_id = $classroom_id AND booking_enddate > CURDATE()";

      // spara bokningsdata i array för senare användning
      $bookings = array();

      // överför data från resultatet till array
      if ($result = mysqli_query($mysqli, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
          // lägg in respektive rad från databasen i arrayen $bookings
          array_push($bookings, $row);
        }
      }

      //var_dump($bookings);

      // startdatum för kalendern: första dagen i aktuell månad
      // Y-m = ex. 2013-12-01
      $startdate = new DateTime(date("Y-m"));

      // slutdatum för kalendern: startdatum + 6 månader (eller mer)
      // ex. $months_to_show = 6 -> P6M -> 6 månader
      $enddate = clone $startdate;
      $enddate->add(new DateInterval('P'.$months_to_show.'M'));

      // fastställ hur kalendern ska grupperas
      // P1M = 1 månad = månadsvis
      $month_interval = new DateInterval('P1M');

      // fastställ hur många grupperingar som ska förekomma i datumspannet
      // mellan startdatum och slutdatum om man delar in det i månader ($month_interval)
      $month_period = new DatePeriod($startdate, $month_interval, $enddate);

      // loop för varje månad i datumspannet
      foreach ($month_period as $month) {
        // ta ut sista datumet i månaden
        // t = sista dagens nummer i månaden, ex. 31
        $days_of_month = $month->format("t");
        $end_of_month = new DateTime($month->format("Y-m-t"));
        // måste lägga till en extra dag för att datumintervallen
        // ska fungera av någon anledning
        $end_of_month->add(new DateInterval('P1D'));

        // fastställ hur månaden ska grupperas
        // P1D = 1 dag = dagsvis
        $day_interval = new DateInterval('P1D');

        // fastställ hur många grupperingar (av dagar) som ska förekomma i månaden
        // antalet dagar mellan första dagen i månaden och sista dagen i månaden
        $day_period = new DatePeriod($month, $day_interval, $end_of_month);

        // den totala bredden av månaden beror på antalet dagar
        // en fullösning...
        $width = $days_of_month*15;

        // skriv ut HTML-koden för respektive månad
        echo "<div class='month'>";
        echo   "<div class='dashes' style='width:".$width."px'></div>";
        echo   "<div class='startdate'>".$month->format("M Y")."</div>";
        echo   "<div class='clearfix'></div>";

        // loop för varje dag i månaden
        foreach ($day_period as $day) {
          // gör om till time för att kunna jämföra med andra datum
          $day_totime = strtotime($day->format("Y-m-d"));

          // klass för dagens div (booked_fm och/elelr booked_em)
          $class = "";
          $bk_id = "";
          $bk_printstart = "";
          $bk_printend = "";
          $bk_firstname = "";
          $bk_lastname = "";

          // loop för alla bokningar av det aktuella klassrummet (se SQL query ovanför i koden)
          // avgör om den finns en eller flera överlappande bokning för respektive dag
          foreach ($bookings as $booking) {
            // gör om till time för att kunna jämföra datum
            $bk_startdate = strtotime($booking["booking_startdate"]);
            $bk_enddate = strtotime($booking["booking_enddate"]);
            $bk_timeperiod = isset($booking["bookingtime_id"]) ? $booking['bookingtime_id'] : '';

            // om det finns en överlappande bokning: markera som "bokad" med css-klass
            if ($day_totime >= $bk_startdate && $day_totime <= $bk_enddate) {
              if ($bk_timeperiod == 1) {
                $bk_id = $booking["booking_id"]." ";
                $bk_printstart = date("Y-m-d", $bk_startdate)." ";
                $bk_printend = date("Y-m-d", $bk_enddate)." ";
                $bk_firstname = $booking["user_firstname"]." ";
                $bk_lastname = $booking["user_lastname"];
                $class .= " booked_fm";
              }
              else if ($bk_timeperiod == 2) {
                $bk_id = $booking["booking_id"]." ";
                $bk_printstart = date("Y-m-d", $bk_startdate)." ";
                $bk_printend = date("Y-m-d", $bk_enddate)." ";
                $bk_firstname = $booking["user_firstname"]." ";
                $bk_lastname = $booking["user_lastname"];
                $class .= " booked_em";
              }
            }
          }

          // skriv ut HTML-koden för respektive dag
          // de tomma divarna blir orange respektive röd om
          // de har css-klasserna booked_fm eller booked_em
          echo "<div class='".$bk_id."empty day$class' id='".$day->format("Y-m-d")."'>";
          echo   "<span class='".$bk_printstart.$bk_printend.$bk_firstname.$bk_lastname."'>".$day->format("j")."</span>";
          echo "</div>";
        }

        // avsluta diven för månad
        echo   "<div class='clearfix'></div>";
        echo "</div>";
      }

      // skriv ut länk för att visa fler månader i kalendern
      echo "<a class='load-months' href='?course=$course_id&classroom=$classroom_id&months=".($months_to_show+6)."'>Ladda in fler månader</a>";
      */
      ?>

    </div>

  <?php } ?>

</div>

<div class="clearfix"></div>