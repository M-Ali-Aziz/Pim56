<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<?php if (!$this->rssFeed) : ?>
  <h2>RSS</h2>
  <p>Not connected to RSS feed.</p>
<?php else :?>
  <!-- rssFeedArray -->
  <?php $rssFeedArray = ($this->pagination && $this->paginator) ?
    $this->paginator : $this->rssFeedArray ?>

  <!-- Heading -->
  <h2><?php echo $this->heading; ?></h2>

  <!-- Rss Feed content -->
  <?php foreach($rssFeedArray as $item): ?>
    <?php
      switch($this->brickName):
        case 'mainAreablock':
    ?>
        <h3><a href="<?php echo $item['link']; ?>"><?php echo $item['title']; ?></a></h3>
        <p>
          <span style="text-transform:uppercase;"><?php echo $item['creator']; ?></span> 
          <?php echo strftime("%Y-%m-%d", strtotime($item['pubDate'])); ?><br>
          <?php
            if($this->checkbox("descriptionLong")->isChecked()):
                echo $item['description'];
            elseif( ! $this->checkbox("descriptionNone")->isChecked()):
                echo $this->summary($item['description'], 80);
            endif;
          ?>
        </p>
      <?php 
        break;
        default:
      ?>
        <p>
          <a href="<?php echo $item['link']; ?>"><?php echo $item['title']; ?></a><br>
          <em><?php echo strftime("%Y-%m-%d", strtotime($item['pubDate'])); ?></em><br>
          <?php
            if($this->checkbox("descriptionLong")->isChecked()):
                echo $item['description'];
            elseif( ! $this->checkbox("descriptionNone")->isChecked()):
                echo $this->summary($item['description'], 80);
            endif;
          ?>
        </p>
    <?php 
        break;
      endswitch;
    ?>
  <?php endforeach; ?>

  <p>
  <a href="<?php echo $this->input("linkUrl"); ?>"><?php echo $this->input("linkHeading"); ?></a>
  </p>

<?php $paginationViewPath = (($this->document->getProperty("bootstrap")) ? 'Bootstrap/Navigation/pagination.html.php' : 'Navigation/pagination.html.php'); ?>

  <!-- pagination controller -->
  <?php
    if($this->pagination && $this->paginator):
        echo $this->render(
            "$paginationViewPath",
            array(
                'paginatorPages' => $this->paginator->getPages("Sliding"),
                'urlprefix' => $this->document->getFullPath() . '?page=',
                'appendQueryString' => true
            )
        );
    endif;
  ?>
<?php endif;?>