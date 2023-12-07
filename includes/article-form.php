<?php  if(!empty($error) ): ?>
    <ul>
        <?php foreach ($error as $errorText):?>
        <li><?= $errorText; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif;?>
<form action="" method="post">
    <div>
        <label for="title">Title:</label>
        <input name="text" id="title" placeholder= "Article name" value ="<?= htmlspecialchars($title); ?>" >
    </div>
    <div>
        <label for="content">Content:</label>
        <textarea name="content" id="content" cols="40" rows="4" placeholder="Article body"><?= htmlspecialchars($content); ?></textarea>
    </div>
    <div>
        <label for="date">Date:</label>
        <input type="text" id="date" name="date" value ="<?= htmlspecialchars($date); ?>">
    </div>
    <button>Submit</button> 
    <br>
    <a href="index.php">Cancel</a>
</form>