<?php get_header(); ?>

<main class="main">


	<section class="sec-404 tac">
		<header>
			<h1 class="ttlS01">お探しのページが見つかりませんでした。</h1>
		</header>

		<p class="txt-base tac">
			ご指定いただいたページが見つかりませんでした。<br>
			お探しのページは一時的にアクセスできない状況にあるか、<br>
			移動もしくは削除された可能性があります。
		</p>
		<div class="block01">
			<h2 class="ttlS01">サイト内検索</h2>
			<form class="form404" method="get" action="<?php echo home_url(); ?>">
				<input class="iptxt" type="text" name="s" value="">
				<input class="ipsbmt" type="submit" value="検索">
			</form>
		</div>
		<p class="wrap_btn"><a class="btn02" href="<?php echo home_url(); ?>/">トップページへ戻る</a></p>
	</section>


</main>

<?php get_footer(); ?>
