<?php
$disabled = '';
$reportStatus = get_post_meta($post->ID, 'unicheck_report_status');
if (!empty($reportStatus)) {
    if ($reportStatus[0] == "0") {
        $disabled = 'disabled';
    }
}
?>

<script>
    var post = document.getElementById("post");
    var parent = post.parentNode;
    var insertForm = document.createElement("form");

    insertForm.setAttribute("action", "<?php echo admin_url('admin-post.php')?>");
    insertForm.setAttribute("id", "plagiarism-btn");
    insertForm.setAttribute("style", "float:right;margin-top:-30px;margin-right:275px;");

    parent.insertBefore(insertForm, post);

    document.getElementById("plagiarism-btn").innerHTML = '<input type="hidden" name="action" value="plagiarism_check"><input type="hidden" name="post_id" value="<?php echo $post->ID; ?>"><input type="submit" class="button-secondary" id="validateContent" value="Validate Content" <?php echo $disabled; ?> style="background-color:blue;color:white;border-color: blue;box-shadow: 0 1px 0 blue;">';
</script>
