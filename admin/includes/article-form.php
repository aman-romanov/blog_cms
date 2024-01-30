<?php  if(!empty($article->error) ): ?>
    <ul>
        <?php foreach ($article->error as $errorText):?>
        <li><?= $errorText; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif;?>
<form id="article-form" action="" method="post">
    <div>
        <label for="title">Title:</label>
        <input name="text" id="title" placeholder= "Article name" value ="<?= htmlspecialchars($article->title ?? ""); ?>" >
    </div>
    <div>
        <label for="content">Content:</label>
        <textarea name="content" id="content" cols="40" rows="4" placeholder="Article body"><?= htmlspecialchars($article->content ?? ""); ?></textarea>
    </div>
    <div>
        <label for="date">Date:</label>
        <input id="date" name="date" value ="<?= htmlspecialchars($article->published_at ?? ""); ?>">
    </div>
    <fieldset>
        <legend>Categories:</legend>
        <?php foreach($categories as $category):?>
            <div>
                <input type="checkbox" name="category[]" value="<?=$category['id'];?>" id="category<?=$category['id'];?>" <?php if(in_array($category['id'], $category_ids)):?> checked <?php endif;?>>
                <label for="category<?=$category['id'];?>"> <?= htmlspecialchars($category['category'] ?? ""); ?> </label>
            </div>
        <?php endforeach;?>
    </fieldset>
    <button>Submit</button> 
    <br>
    <a href="index.php">Cancel</a>
</form>
<script   src="https://code.jquery.com/jquery-3.7.1.min.js"   integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="   crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" ></script>
<script src="../js/script.js"></script>