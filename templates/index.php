<?php 
  $this->layout('master', ['title' => 'Blue Jeans Investing']) ;
  $pageContent = $this->renderPostContent();
  $isSearchResultsLayout = false;

  if(isset($_POST['searchSubmitted'])) {
      $search_terms = htmlspecialchars($_POST['searchTerms']);
      $searchResults = $this->searchFunc($search_terms);
      $isSearchResultsLayout = true;
  }

  $isHidden = ($isSearchResultsLayout) ? "display:none;" : "";
  $isNotHidden = (!$isSearchResultsLayout) ? "display:none;" : "";
?>
<section class="s-featured">
    <div class="row">

      <h1 style=<?php echo("text-align:center;" . $isNotHidden); ?>>Search Results For: <?php echo($search_terms); ?></h1>
      <section class="s-content" style=<?php echo($isNotHidden); ?>>

        <div class="row entries-wrap wide">
            <div class="entries">

                <?php 
                    if(count($searchResults) > 0) {
                      for ($i=0; $i < count($searchResults); $i++) { 
                        echo('
                          <article class="col-block">
                              <div class="item-entry" data-aos="zoom-in">
                                  <div class="item-entry__thumb">
                                      <a href="single-standard.html" class="item-entry__thumb-link">
                                          <img src=' . $searchResults[$i][3] . ' alt="">
                                      </a>
                                  </div>
                                  <div class="item-entry__text">    
                                      <div class="item-entry__cat">
                                      <p></p>                                  
                                      </div>
                                      <h1 class="item-entry__title"><a href=single.php?id=' . $searchResults[$i][0] . '>' . $searchResults[$i][1] . '</a></h1>
                                      <div class="item-entry__date">
                                          <a href=single.php?id=' . $searchResults[$i][0] . '>' . $searchResults[$i][2] . '</a>
                                      </div>
                                  </div>
                              </div> 
                          </article>'
                        );
                      };
                    }
                    else {
                      echo('<h1 style="text-align:center;">Sorry, We Could Not Find Anything...</h1>');
                    } 
                      ?>

              </div>
            </div>
          </section>

        <div class="col-full" style=<?php echo($isHidden); ?>>

            <h1 class="display-1 display-1--with-line-sep text-center">Blue Jeans Investing</h1>
            <div class="featured-slider featured" data-aos="zoom-in">
                <div class="featured__slide">
                    <div class="entry">

                        <div class="entry__background" style="background-image:url(<?php echo($pageContent[0][4]); ?>);"></div>
                        <div class="entry__content">
                            <span class="entry__category">
                              <a href="#0">
                                <?php echo($pageContent[0][0]); ?>                                  
                              </a>
                            </span>
                            <h1>
                              <a href=<?php echo("single.php?id=" . $pageContent[0][1]); ?> title="">
                                <?php echo($pageContent[0][2]); ?>                                  
                              </a>
                            </h1>
                        </div>                            
                    </div>

                </div> 
                <div class="featured__slide">
                    <div class="entry">

                        <div class="entry__background" style="background-image:url(<?php echo($pageContent[1][4]); ?>);"></div>
                        <div class="entry__content">
                            <span class="entry__category">
                              <a href="#0">
                                <?php echo($pageContent[1][0]); ?>                                
                              </a>
                            </span>
                            <h1>
                              <a href=<?php echo("single.php?id=" . $pageContent[1][1]); ?> title="">
                                <?php echo($pageContent[1][2]); ?>                                  
                              </a>
                            </h1>
                        </div>          
                    </div>

                </div> 
                <div class="featured__slide">
                    <div class="entry">

                        <div class="entry__background" style="background-image:url(<?php echo($pageContent[2][4]); ?>);"></div>
                        <div class="entry__content">
                            <span class="entry__category">
                              <a href="#0">
                                <?php echo($pageContent[2][0]); ?>                                  
                              </a>
                            </span>
                            <h1>
                              <a href=<?php echo("single.php?id=" . $pageContent[2][1]); ?>title="">
                                <?php echo($pageContent[2][2]); ?>                                
                              </a>
                            </h1>
                        </div> 
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<section class="s-content" style=<?php echo($isHidden); ?>>
    <div class="row entries-wrap wide">
        <div class="entries">
            <article class="col-block">
                <div class="item-entry" data-aos="zoom-in">
                    <div class="item-entry__thumb">
                        <a href="single-standard.html" class="item-entry__thumb-link">

                            <img src=<?php echo($pageContent[3][4]); ?> alt="">

                        </a>
                    </div>
                    <div class="item-entry__text">    
                        <div class="item-entry__cat">
                            <p>
                              <?php echo($pageContent[3][0]); ?>                                
                            </p> 
                        </div>
                        <h1 class="item-entry__title">
                          <a href=<?php echo("single.php?id=" . $pageContent[3][1] . ">" . $pageContent[3][2]); ?>
                          </a>
                        </h1>
                        <div class="item-entry__date">
                            <a href=<?php echo("single.php?id=" . $pageContent[3][1]); ?>title="">
                              <?php echo($pageContent[3][3]); ?>                                
                            </a>
                        </div>
                    </div>
                </div> 
            </article> 
            <article class="col-block">
                <div class="item-entry" data-aos="zoom-in">
                    <div class="item-entry__thumb">
                        <a href="single-standard.html" class="item-entry__thumb-link">

                            <img src=<?php echo($pageContent[4][4]); ?> alt="">

                        </a>
                    </div>
                    <div class="item-entry__text">    
                        <div class="item-entry__cat">
                            <p>
                              <?php echo($pageContent[4][0]); ?>                                
                            </p> 
                        </div>
                        <h1 class="item-entry__title">
                          <a href=<?php echo("single.php?id=" . $pageContent[4][1] . ">" . $pageContent[4][2]); ?>
                          </a>
                        </h1>
                        <div class="item-entry__date">
                            <a href=<?php echo("single.php?id=" . $pageContent[4][1]); ?>title=""><?php echo($pageContent[4][3]) ?>
                            </a>
                        </div>
                    </div>

                </div> 
            </article> 
            <article class="col-block">                
                <div class="item-entry" data-aos="zoom-in">
                    <div class="item-entry__thumb">
                        <a href="single-standard.html" class="item-entry__thumb-link">

                            <img src=<?php echo($pageContent[5][4]); ?> alt="">

                        </a>
                    </div>
                    <div class="item-entry__text">    
                        <div class="item-entry__cat">
                            <p>
                              <?php echo($pageContent[5][0]); ?>                                
                            </p> 
                        </div>
                        <h1 class="item-entry__title">
                          <a href=<?php echo("single.php?id=" . $pageContent[5][1] . ">" . $pageContent[5][2]); ?>
                          </a>
                        </h1>
                        <div class="item-entry__date">
                            <a href=<?php echo("single.php?id=" . $pageContent[5][1]); ?>title=""><?php echo($pageContent[5][3]); ?> 
                            </a>
                        </div>
                    </div>

                </div> 
            </article>
</section>
<section class="s-extra" style=<?php echo($isHidden); ?>>
    <div class="row">
        <div class="col-four md-four tab-full popular">
            <h3>Nasdaq</h3>
           <!-- TradingView Widget BEGIN -->
                <div class="tradingview-widget-container">
                  <div id="tradingview_4fc38"></div>
                  <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/symbols/NASDAQ-IXIC/" rel="noopener" target="_blank"><span class="blue-text">IXIC chart</span></a> by TradingView</div>
                  <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                  <script type="text/javascript">
                  new TradingView.widget(
                  {
                  "width": 350,
                  "height": 600,
                  "symbol": "NASDAQ:IXIC",
                  "interval": "D",
                  "timezone": "Etc/UTC",
                  "theme": "Dark",
                  "style": "1",
                  "locale": "en",
                  "toolbar_bg": "#f1f3f6",
                  "enable_publishing": false,
                  "hide_top_toolbar": true,
                  "save_image": false,
                  "container_id": "tradingview_4fc38"
                }
                  );
                  </script>
                </div>
                <!-- TradingView Widget END -->
        </div> 
        <div class="col-eight md-eight tab-full end">
            <div class="row">
                <div class="col-six md-six mob-full categories">
                    <h3>Dow Jones</h3>
                   <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                      <div id="tradingview_1e542"></div>
                      <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/symbols/DJ-DJI/" rel="noopener" target="_blank"><span class="blue-text">DJI chart</span></a> by TradingView</div>
                      <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                      <script type="text/javascript">
                      new TradingView.widget(
                      {
                      "width": 350,
                      "height": 600,
                      "symbol": "DJ:DJI",
                      "interval": "D",
                      "timezone": "Etc/UTC",
                      "theme": "Dark",
                      "style": "1",
                      "locale": "en",
                      "toolbar_bg": "#f1f3f6",
                      "enable_publishing": false,
                      "hide_top_toolbar": true,
                      "save_image": false,
                      "container_id": "tradingview_1e542"
                    }
                      );
                      </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div> 
                <div class="col-six md-six mob-full sitelinks">
                    <h3>S&P 500</h3>
                  <!-- TradingView Widget BEGIN -->
                        <div class="tradingview-widget-container">
                          <div id="tradingview_5aa48"></div>
                          <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/symbols/SP-SP500G/" rel="noopener" target="_blank"><span class="blue-text">SP500G chart</span></a> by TradingView</div>
                          <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                          <script type="text/javascript">
                          new TradingView.widget(
                          {
                          "width": 350,
                          "height": 600,
                          "symbol": "SP:SP500G",
                          "interval": "D",
                          "timezone": "Etc/UTC",
                          "theme": "Dark",
                          "style": "1",
                          "locale": "en",
                          "toolbar_bg": "#f1f3f6",
                          "enable_publishing": false,
                          "hide_top_toolbar": true,
                          "save_image": false,
                          "container_id": "tradingview_5aa48"
                        }
                          );
                          </script>
                        </div>
                        <!-- TradingView Widget END -->
                </div> 
            </div>
        </div>
    </div> 
</section> 
