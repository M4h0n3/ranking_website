      <!-- start content -->
      <div id="content">
        <?php
        require_once("../../mysql_connect.php");
        $player_name = $_GET["player"];

        if(isset($player_name)){

          echo '<h1>' . $player_name . '</h1>';
          echo '<canvas id="myChart" width="500" height="500"></canvas>';
          
          $query = "SELECT date, tournament, winner, loser, winner_elo, loser_elo FROM elo_matches WHERE winner='$player_name' OR loser='$player_name' ORDER BY date";
          $response = @mysqli_query($dbc, $query);

          $match_names = [];
          $match_elos = [];
          $opponent;
          $result_type;

          echo '
          <h1>Match History</h1>
          <table>
            <thead>
              <th>Tournament</th>
              <th>Result</th>
              <th>Opponent</th>
            </tr>
          </thead><tbody>';

        // mysqli_fetch_array will return a row of data from the query
        // until no further data is available
          while($row = mysqli_fetch_array($response)){

        //add to tournaments array if new
            if($player_name == $row['winner']){
              $opponent = $row['loser'];
              $match_names[] = "Win vs " . $opponent;
              $match_elos[] = $row['winner_elo'];
              $result_type = '<span style="color:green">Victory</span>';

            }
            else{
              $opponent = $row['winner'];
              $match_names[] = "Loss vs " . $opponent;
              $match_elos[] = $row['loser_elo'];
              $result_type = '<span style="color:red">Defeat</span>';
            }

            echo '<tr><td>' .
            $row['tournament'] . '</td><td>' . 
            $result_type . '</td><td>' .
            $opponent . '</td><td>';

            echo '</tr>';

          }

          echo '</tbody></table>';
        }
        else{
          echo "error";
        }


        echo '<script>
        var data = {
          labels: [';

          foreach($match_names as $match_name){
            echo '"' . $match_name . '" ,'; 
          }

          echo '],
          datasets: [
          {
            label: "Data",
            fillColor: "rgba(220,220,220,0.2)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(0,0,0,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: [';

            foreach($match_elos as $match_elo){
              echo $match_elo . ', '; 
            }
            echo ']
          }]
        };

        var ctx = document.getElementById("myChart").getContext("2d");
        var myLineChart = new Chart(ctx).Line(data, {
          bezierCurve : false,
          datasetFill: false,
          pointDotRadius : 4,
          pointHitDetectionRadius : 3,
        });
    </script>';



    ?>


