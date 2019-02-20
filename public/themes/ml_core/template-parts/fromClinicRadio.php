<?php
global $value;
global $blog_id;

$keyReach = "requestedPostDistribution";
$keyID = "siteOriginID";

$localText = "My Site";

$data = get_post_meta( $post->ID, $keyReach, true );
$originID = get_post_meta( $post->ID, $keyID, true );

switch_to_blog($originID);
$originName = get_bloginfo( 'name' );
restore_current_blog();

$checkedLocal = "";
$checkedRegion = "";
$checkedNetwork = "";
$disabled = "";

if ($data === "local") {
    $checkedLocal = "checked";
}
if ($data === "region") {
    $checkedRegion = "checked";
}
if ($data === "network") {
    $checkedNetwork = "checked";
}

if ($blog_id === 1) {
    $disabled = " disabled";
    $localText = 'Local: <small><a href="'.get_site_url($originID).'" target="_blank">'.$originName.'</a></small>';
}

?>
<form>
    <input type="radio" name="distribution" value="local" id="local" <?php checked( $data, 'local' ); echo $checkedLocal; echo $disabled;?> required><label for="local"><?php echo $localText; ?></label><br>
    <input type="radio" name="distribution" value="region" id="region" <?php checked( $data, 'region' ); echo $checkedRegion; echo $disabled; ?> required><label for="region">My Region (Eg: Florida)</label><br>
    <input type="radio" name="distribution" value="network" id="network" <?php checked( $data, 'network' ); echo $checkedNetwork; echo $disabled; ?> required><label for="network">Network Wide</label><br>
</form>
