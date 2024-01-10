<div>Welcome!</div>
<br/>
<nav>
    <ul>
        <?php if (!Auth::isLoggedIn()):?>
            <li><a href="/cms_blog/login.php">Login</a></li>
        <?php else:?>
            <li><a href="/cms_blog/admin/index.php">Admin</a></li>
            <li><a href="/cms_blog/logout.php">Logout</a></li>
            <li><a href="/cms_blog/admin/new-article.php">Create new article</a></li>
        <?php endif;?>
    </ul>
</nav>