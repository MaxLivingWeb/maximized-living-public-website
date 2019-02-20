<?php

global $status;

?>

<script>
    var post = document.getElementById("post");
    var parent = post.parentNode;
    var insertForm = document.createElement("form");

    insertForm.setAttribute("id", "plagiarism-report-btn");
    insertForm.setAttribute("style", "float:right;margin-top:-30px;margin-right:400px;");

    parent.insertBefore(insertForm, post);

    <?php
    if ($status[0] == 1):?>

    document.getElementById("plagiarism-report-btn").innerHTML = '<a href="<?php echo get_post_meta($post->ID, 'unicheck_report')[0]; ?>" target="_blank" class="button-secondary" title="View Report">View Report</a>';

    <?php else: ?>

    document.getElementById("plagiarism-report-btn").innerHTML = '<a href="<?php echo admin_url('post.php?post='.$post->ID.'&action=edit'); ?>" class="button-secondary" title="Click to check report status">Generating Report</a>';

    <?php endif; ?>
</script>
