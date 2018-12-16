<?php 
  session_start();
  $this->layout('master', ['title' => 'Dashboard']);

  if(isset($_POST['loginSubmitted'])) {
      $msg = "";
      if(!$_POST['loginUserName']) {
        $msg = "<p>Please Enter Your User Name.</p>\n";      
          if(!$_POST['loginUserPass']) {
            $msg = "<p>Please Enter a Password.</p>\n";        
        }          
        echo(" <script src='js/jquery-3.2.1.min.js'></script>
                    <script src='js/plugins.js'></script>
                    <script src='js/main.js'></script> 
            ");           
      }
      else {
        $userDetails = $this->verifyUser(htmlspecialchars($_POST['loginUserName']), $_POST["loginUserPass"]);  
        if(count($userDetails) > 0) {
          $_SESSION['loggedIn'] = true;
          $_SESSION['FName'] = $userDetails[0];
          $_SESSION['ticker1'] = ($userDetails[1] == null) ? 'DJ:DJI' : $userDetails[1];
          $_SESSION['ticker2'] = ($userDetails[2] == null) ? 'NASDAQ:IXIC' : $userDetails[2];
          $_SESSION['ticker3'] = ($userDetails[3] == null) ? 'SP:SPX' : $userDetails[3];
        }
      }
    }
    if(isset($_POST['tickerSubmitted'])){
      //Make API Call, and Figure out way to test on Trading view, then check for nulls in DB, then if all filled fill up first slot
      $addTicker = $this->addSymbol(htmlspecialchars($_POST['newTickerInput']), $_SESSION['FName']);
      $tickerCounter = 1;
      foreach ($addTicker as $x) {
        $_SESSION["ticker" . $tickerCounter] = $x;
        if(is_null($x)){
          switch ($tickerCounter) {
            case 1:
              $_SESSION['ticker1'] = 'DJ:DJI';
              break;
            case 2:
              $_SESSION['ticker2'] = 'NASDAQ:IXIC';
              break;
            case 3:
              $_SESSION['ticker3'] = 'SP:SPX';
              break;
          }
        }
        $tickerCounter++;
      }


    }
    // Delete Ticker 1
    if(isset($_POST['ticker1Submitted'])) {
      if($_POST['ticker1'] === "DJ:DJI"){
      }
      else {
        $deleteTicker = $this->deleteSymbol(1, $_SESSION["FName"]);
          $tickerCounter = 1;
          foreach ($deleteTicker as $x) {
            $_SESSION["ticker" . $tickerCounter] = $x;
            if(is_null($_SESSION["ticker" . $tickerCounter])){
              switch ($tickerCounter) {
                case 1:
                  $_SESSION['ticker1'] = 'DJ:DJI';
                  break;
                case 2:
                  $_SESSION['ticker2'] = 'NASDAQ:IXIC';
                  break;
                case 3:
                  $_SESSION['ticker3'] = 'SP:SPX';
                  break;
              }
            }
            $tickerCounter++;
          }
      }
    }
    // Delete Ticker 2
    if(isset($_POST['ticker2Submitted'])) {
          if($_POST['ticker2'] === "NASDAQ:IXIC"){

        }
        else {
          $deleteTicker = $this->deleteSymbol(2, $_SESSION["FName"]);
          $tickerCounter = 1;
          foreach ($deleteTicker as $x) {
            $_SESSION["ticker" . $tickerCounter] = $x;
            if(is_null($_SESSION["ticker" . $tickerCounter])){
              switch ($tickerCounter) {
                case 1:
                  $_SESSION['ticker1'] = 'DJ:DJI';
                  break;
                case 2:
                  $_SESSION['ticker2'] = 'NASDAQ:IXIC';
                  break;
                case 3:
                  $_SESSION['ticker3'] = 'SP:SPX';
                  break;
              }
            }
            $tickerCounter++;
          }
        }
    }
    // Delete Ticker 3
    if(isset($_POST['ticker3Submitted'])) {
          if($_POST['ticker3'] === "SP:SPX"){
        }
        else {
          $deleteTicker = $this->deleteSymbol(3, $_SESSION["FName"]);
            $tickerCounter = 1;
          foreach ($deleteTicker as $x) {
            $_SESSION["ticker" . $tickerCounter] = $x;
            if(is_null($_SESSION["ticker" . $tickerCounter])){
              switch ($tickerCounter) {
                case 1:
                  $_SESSION['ticker1'] = 'DJ:DJI';
                  break;
                case 2:
                  $_SESSION['ticker2'] = 'NASDAQ:IXIC';
                  break;
                case 3:
                  $_SESSION['ticker3'] = 'SP:SPX';
                  break;
              }
            }
            $tickerCounter++;
          }
        }
    }

      if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
        // Predifined Settings
        $widgetWidth = "100%";
        $widgetHeight = "100%";
        $widgetLocale = "en";
        $widgetInterval = "1D";
        // Create new object ticker object so we json encode it
        $ticker1 = new stdClass();
        $ticker1->width = $widgetWidth;
        $ticker1->height = $widgetHeight;
        $ticker1->symbol = $_SESSION['ticker1'];
        $ticker1->locale = $widgetLocale;
        $ticker1->interval = $widgetInterval;
        $jsonTicker1 = json_encode($ticker1);
        // Grab Current prices for ticker 1
        $ticker1URL = ($_SESSION['ticker1'] == 'DJ:DJI') ? "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=DJI&apikey=KBE1FWN6A9NDD5JR" : "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=". $ticker1->symbol . "&apikey=KBE1FWN6A9NDD5JR";
        $ticker1JSON = file_get_contents($ticker1URL);
        $ticker1Response = json_decode($ticker1JSON, true);
        $ticker1LatestDate = $ticker1Response['Meta Data']['3. Last Refreshed'];
        $ticker1date = substr($ticker1LatestDate, 0, 10);
        $ticker1CurrentPrice = $ticker1Response['Time Series (Daily)'][$ticker1date]['4. close'];
        // Create new second ticker
        $ticker2 = new stdClass();
        $ticker2->width = $widgetWidth;
        $ticker2->height = $widgetHeight;
        $ticker2->symbol = $_SESSION['ticker2'];
        $ticker2->locale = $widgetLocale;
        $ticker2->interval = $widgetInterval;
        $jsonTicker2 = json_encode($ticker2);
        // Grab Current Prices for ticker 2
        $ticker2URL = ($_SESSION['ticker2'] == 'NASDAQ:IXIC') ? "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=NASDAQ:IXIC&apikey=KBE1FWN6A9NDD5JR" : "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=". $ticker2->symbol . "&apikey=KBE1FWN6A9NDD5JR";
        $ticker2JSON = file_get_contents($ticker2URL);
        $ticker2Response = json_decode($ticker2JSON, true);
        $ticker2LatestDate = $ticker2Response['Meta Data']['3. Last Refreshed'];
        $ticker2date = substr($ticker2LatestDate, 0, 10);
        $ticker2CurrentPrice = $ticker2Response['Time Series (Daily)'][$ticker2date]['4. close'];      
        // Create third ticker
        $ticker3 = new stdClass();
        $ticker3->width = $widgetWidth;
        $ticker3->height = $widgetHeight;
        $ticker3->symbol = $_SESSION['ticker3'];
        $ticker3->locale = $widgetLocale;
        $ticker3->interval = $widgetInterval;
        $jsonTicker3 = json_encode($ticker3);
        // Grab Current Prices for ticker 3
        $ticker3URL = ($_SESSION['ticker3'] == 'SP:SPX') ? "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=SPX&apikey=KBE1FWN6A9NDD5JR" : "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=". $ticker3->symbol . "&apikey=KBE1FWN6A9NDD5JR";
        $ticker3JSON = file_get_contents($ticker3URL);
        $ticker3Response = json_decode($ticker3JSON, true);
        $ticker3LatestDate = $ticker3Response['Meta Data']['3. Last Refreshed'];
        $ticker3date = substr($ticker3LatestDate, 0, 10);
        $ticker3CurrentPrice = $ticker3Response['Time Series (Daily)'][$ticker3date]['4. close'];
      
?>

<section class="s-featured">
	<div class="container text-center dash-welcome">
		<div class="row">
            <div class="dash-welcome-message">
                <h1 class="entry__header-title display-1" style="padding: 20px;">
                  Welcome Back, <?php echo($_SESSION['FName']); ?>                    
                </h1>
            </div>
        </div>
		<div class="row">
            <div class="entries">
    			<div class="col-four">
                    <div class="item-entry" style="background-color: rgba(255,255,255,0.8);">
                        <div class="item-entry__thumb" style="height: 400px;">                        
                        <!-- TradingView Widget BEGIN -->
                          <div class="tradingview-widget-container">
                            <div class="tradingview-widget-container__widget"></div>
                            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-technical-analysis.js" async>

                            <?php echo($jsonTicker1) ?>

                            </script>
                          </div>
                          <!-- TradingView Widget END -->
                        </div>
                        <h1 class="item-entry__title">

                        <?php echo('Last: ' . $ticker1CurrentPrice); ?>

                        </h1>
                        <div class="item-entry__date">

                            <?php echo($ticker1LatestDate); ?>

                        </div>
                    </div>
                </div>
    			<div class="col-four">
                    <div class="item-entry" style="background-color: rgba(255,255,255,0.8);">
                        <div class="item-entry__thumb" style="height: 400px;">
                        <!-- TradingView Widget BEGIN -->
                            <div class="tradingview-widget-container">
                              <div class="tradingview-widget-container__widget"></div>
                              <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-technical-analysis.js" async>

                              <?php echo($jsonTicker2); ?>

                              </script>
                            </div>
                            <!-- TradingView Widget END -->
                        </div>
                         <h1 class="item-entry__title">

                          <?php echo('Last: ' . $ticker2CurrentPrice); ?>

                        </h1>
                        <div class="item-entry__date">

                            <?php echo($ticker2LatestDate); ?>

                        </div>
                    </div>
                </div>
    			<div class="col-four">
                    <div class="item-entry" style="background-color: rgba(255,255,255,0.8);">                        
                        <div class="item-entry__thumb" style="height: 400px;">
                            <!-- TradingView Widget BEGIN -->
                            <div class="tradingview-widget-container">
                              <div class="tradingview-widget-container__widget"></div>
                              <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-technical-analysis.js" async>

                              <?php echo($jsonTicker3); ?>

                              </script>
                            </div>
                            <!-- TradingView Widget END -->
                        </div>
                        <h1 class="item-entry__title">

                          <?php echo('Last: ' . $ticker3CurrentPrice); ?>

                        </h1>
                        <div class="item-entry__date">

                            <?php echo($ticker3LatestDate); ?>

                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</section>
<section class="s-content">
    <div class="row entries-wrap wide">
        <div class="entries">
            <article class="col-full">            
                <div class="item-entry" data-aos="zoom-in">
                    <div class="item-entry__thumb" style="height: 500px;">

                        <!-- TradingView Widget BEGIN -->
                        <div class="tradingview-widget-container">
                          <div id="tv-medium-widget"></div>
                          <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                          <script type="text/javascript">
                          new TradingView.MediumWidget(
                          {
                          "container_id": "tv-medium-widget",
                          "symbols": [

                            <?php echo('"'. $ticker1->symbol . '|1y"') ?>,
                            <?php echo('"'. $ticker2->symbol . '|1y"') ?>,
                            <?php echo('"'. $ticker3->symbol . '|1y"') ?>

                          ],
                          "greyText": "Quotes by",
                          "gridLineColor": "#e9e9ea",
                          "fontColor": "#83888D",
                          "underLineColor": "#dbeffb",
                          "trendLineColor": "#4bafe9",
                          "width": "100%",
                          "height": "100%",
                          "locale": "en"
                        }
                          );
                          </script>
                        </div>
                        <!-- TradingView Widget END -->

                    </div>
                    <div class="item-entry__text">    
                        <div class="item-entry__cat">
                            Please use the tabs on the top of chart to switch views.
                        </div>

                        <h1 class="item-entry__title">Detail Summary</h1>
                            
                    </div>
                </div> 
            </article> 
        </div>
    </div>
</section>
<section class="s-featured">
    <h3 class="entry__header-title display-1 text-center">Edit Ticker List</h3>
	<div class="container text-center">
		<div class="row entries-wrap">
            <div class="entries">
    			<div class="col-full">  
                    <div class="item-entry" data-aos="zoom-in">
                        <div class="tickerSearch">
                        <form method="post" action="#">
                          <!-- if three tickers are not null, alert user to delete symbol or just go ahread and overide on -->
                            <input type="text" name="newTickerInput" placeholder="Add a New Ticker" style="width: 100%">
                            <button type="submit" class="btn addTickerBtn" name="tickerSubmitted" value=""><i class="fas fa-4x fa-plus-square"></i></button>
                        </form>
                        </div>
                        <div class="tickerList">
                            <div class="row">
                                  <form method="post" action="#">
                                    <label class="col-eight" for="ticker1"><?php  echo($ticker1->symbol); ?></label>
                                    <input type="hidden" name="ticker1" value="">
                                    <button type="submit" name="ticker1Submitted" class="col-two"><i class="fas fa-times"></i></button>
                                  </form> 
                                  <form method="post" action="#">
                                    <label class="col-eight" for="ticker2"><?php  echo($ticker2->symbol); ?></label>
                                    <input type="hidden" name="ticker2" value="">
                                    <button type="submit" name="ticker2Submitted" class="col-two"><i class="fas fa-times"></i></button>
                                  </form>  
                                  <form method="post" action="#">
                                    <label class="col-eight" for="ticker3"><?php  echo($ticker3->symbol); ?></label>
                                    <input type="hidden" name="ticker3" value="">
                                    <button type="submit" name="ticker3Submitted" class="col-two"><i class="fas fa-times"></i></button>
                                  </form>                             
                            </div>
                        </div> 
                    </div>               
                </div>
            </div>
		</div>
	</div>
</section>
<?php
  // Close up if statement to make sure user is logged in 
  }
  else
  {
    // Send em back if they are not logged in
    header('Location: /BlueJeansInvesting/index.php');
  }
?>