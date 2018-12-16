  <?php 
      $this->layout('master', ['title' => 'RSI, Is It True?']);
      $pageContent = $this->renderPostContent();
  ?>
    <section class="s-content s-content--top-padding s-content--narrow">
        <article class="row entry format-standard">
            <div class="entry__media col-full">
                <div class="entry__post-thumb">

                    <img src=<?php echo($pageContent[3]); ?> alt="main image">

                </div>
            </div>
            <div class="entry__header col-full">
                <h1 class="entry__header-title display-1">

                    <?php echo($pageContent[1]); ?>

                </h1>
                <ul class="entry__header-meta">
                    <li class="date">
                        <?php echo($pageContent[2]); ?>                            
                    </li>
                    <li class="byline">
                        <p>By <?php echo($pageContent[0]); ?></p>
                    </li>
                </ul>
            </div>
            <div class="col-full entry__main">
                <p class="lead drop-cap">
                    <?php echo($pageContent[5]); ?>                        
                </p>

                <?php 
                    if($pageContent[4] != null) {
                        echo('
                                <p>
                                <img src=' . $pageContent[4] . ' alt="second image">
                                </p>
                            ');
                    } 
                ?>
                
                <div class="entry__author">

                    <img src=<?php echo($pageContent[6]); ?> alt="author image">

                    <div class="entry__author-about">
                        <h5 class="entry__author-name">
                            <span>Posted by</span>
                            <a href="#0">
                                <?php echo($pageContent[8]); ?>                                    
                            </a>
                        </h5>
                        <div class="entry__author-desc">
                            <p>
                                <?php echo($pageContent[7]); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div> <!-- s-entry__main -->
        </article> <!-- end entry/article -->
    </section> <!-- end s-content -->
