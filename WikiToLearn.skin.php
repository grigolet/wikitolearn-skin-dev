<?php
/**
 * Skin file for skin WikitoLearn.
 *
 * @file
 * @ingroup Skins
 */

 /**
  * SkinTemplate class for WikiToLearn skin
  * @ingroup Skins
  */
 class SkinWikiToLearn extends SkinTemplate {
 	  var  $skinname = 'wikitolearn', $stylename = 'WikiToLearn',
 		$template = 'WikiToLearnTemplate', $useHeadElement = true;

 	/**
 	 * Add CSS via ResourceLoader
 	 *
 	 * @param $out OutputPage
 	 */
 	function setupSkinUserCss( OutputPage $out ) {
 		parent::setupSkinUserCss( $out );
 		$out->addModuleStyles( array(
 			'mediawiki.skinning.interface', 'skins.wikitolearn'
 		) );
 	}
 }

 /**
 * BaseTemplate class for WikiToLearn skin
 *
 * @ingroup Skins
 */
class WikiToLearnTemplate extends BaseTemplate {
	/**
	 * Outputs the entire contents of the page
	 */
	public function execute() {
		$this->html( 'headelement' ); ?>

<?php if ( $this->data['newtalk'] ) { ?>
  <div class="usermessage"> <!-- The CSS class used in Monobook and Vector, if you want to follow a similar design -->
    <?php $this->html( 'newtalk' );?>
  </div>
<?php } ?>

<?php if ( $this->data['sitenotice'] ) { ?>
  <div id="siteNotice"> <!-- The CSS class used in Monobook and Vector, if you want to follow a similar design -->
    <?php $this->html( 'sitenotice' ); ?>
  </div>
<?php } ?>

<?php $this->text( 'sitename' ); ?>

<a href="<?php
		echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] );
		// This outputs your wiki's main page URL to the browser.
		?>"
	<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs( 'p-logo' ) ) ?>
>
	<img src="<?php
		 	$this->text( 'logopath' );
		 	// This outputs the path to your logo's image
		 	// You can also use $this->data['logopath'] to output the raw URL of the image. Remember to HTML-escape
		 	// if you're using this method, because the text() method does it automatically.
		?>"
		alt="<?php $this->text( 'sitename' ) ?>"
	>
</a>

<?php
if ( $this->data['title'] != '' ) { // Do not display the HTML tag if it the header is empty
	echo "<h1 id=\"firstHeading\" class=\"firstHeading\">";	// The CSS ID used by MonoBook and Vector.
	$this->html( 'title' );
	echo "</h1>";
} ?>

<?php
if ( $this->data['isarticle'] ) {	// This is an optional test. Vector uses this if-statement to determine if the current page is an article (in the main namespace.)
	 echo '<div id="siteSub">';	// An optional div and CSS ID. This is what MonoBook and Vector use.
	 $this->msg( 'tagline' );
	 echo '</div>';
} ?>

<?php if ( $this->data['subtitle'] ) { ?>
	  <div id="contentSub"> <!-- The CSS class used in Monobook and Vector, if you want to follow a similar design -->
	  <?php $this->html( 'subtitle' ); ?>
	  </div>
<?php } ?>
	  <?php if ( $this->data['undelete'] ) { ?>
	  <div id="contentSub2"> <!-- The CSS class used in Monobook and Vector, if you want to follow a similar design -->
	  <?php $this->html( 'undelete' ); ?>
	  </div>
<?php } ?>

<?php $this->html( 'bodytext' ) ?>

<div id="catlinks" class="catlinks">
	<?php $this->html( 'catlinks' ); ?>
	<div id="mw-normal-catlinks" class="mw-normal-catlinks">
		<a href="/wiki/Special:Categories" title="Special:Categories">Category</a>:
		<?php $this->html( 'catlinks' ); ?>
		<ul>
			<li><a href="/wiki/Category:Help" title="Category:Help">Help</a></li>
		</ul>
	</div>
</div>

<?php echo $this->getIndicators(); ?>

<?php $this->html( 'dataAfterContent' ); ?>

<ul>
<?php
	foreach ( $this->getPersonalTools() as $key => $item ) {
		echo $this->makeListItem( $key, $item );
	}
?>
</ul>

<?php foreach ( $this->data['content_navigation'] as $category => $tabs ) { ?>
<ul>
<?php
	foreach ( $tabs as $key => $tab ) {
		echo $this->makeListItem( $key, $tab );
	}
?>
</ul>
<?php } ?>

<?php
foreach ( $this->getSidebar() as $boxName => $box ) { ?>
<div id="<?php echo Sanitizer::escapeId( $box['id'] ) ?>"<?php echo Linker::tooltip( $box['id'] ) ?>>
	<h5><?php echo htmlspecialchars( $box['header'] ); ?></h5>
	 <!-- If you do not want the words "Navigation" or "Tools" to appear, you can safely remove the line above. -->

<?php
	if ( is_array( $box['content'] ) ) { ?>
	<ul>
<?php
		foreach ( $box['content'] as $key => $item ) {
			echo $this->makeListItem( $key, $item );
		}
?>
	</ul>
<?php
	} else {
		echo $box['content'];
	}
?>
</div>
<?php } ?>

<?php
	// Language links are often not present, so this if-statement allows you to add a conditional <ul> around the language list
	if ( $this->data['language_urls'] ) {
		echo "<ul>";
		foreach ( $this->data['language_urls'] as $key => $langLink ) {
			echo $this->makeListItem( $key, $langLink );
		}
		echo "</ul>";
	}
?>

<ul>
<?php
	foreach ( $this->getToolbox() as $key => $tbitem ) {
		echo $this->makeListItem( $key, $tbitem );
	}
	wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this ) );
?>
</ul>

<form action="<?php $this->text( 'wgScript' ); ?>">
	<input type="hidden" name="title" value="<?php $this->text( 'searchtitle' ) ?>" />
	<?php echo $this->makeSearchInput( array( 'type' => 'text' ) ); ?>
  <?php
    // A "Go" button
    echo $this->makeSearchButton( 'go' );
    // A Full Text "Search" button
    echo $this->makeSearchButton( 'fulltext' );
    // Go button using the button text "Search"
    echo $this->makeSearchButton( 'go', array( 'value' => $this->translator->translate( 'searchbutton' ) ) );
    // An image search button using the images/searchbutton.png image in your skin's folder.
    echo $this->makeSearchButton( 'image', array( 'src' => $this->getSkin()->getSkinStylePath( 'images/searchbutton.png') ) );
  ?>
</form>

<footer>
  <?php
  foreach ( $this->getFooterLinks() as $category => $links ) { ?>
  <ul>
  <?php
  	foreach ( $links as $key ) { ?>
  	<li><?php $this->html( $key ) ?></li>

  <?php
  	} ?>
  </ul>
  <?php
  } ?>
</footer>




<?php $this->printTrail(); ?>
</body>
</html><?php
	}
}
