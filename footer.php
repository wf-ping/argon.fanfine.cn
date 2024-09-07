					<footer id="footer" class="site-footer card shadow-sm border-0">
						<?php
							echo get_option('argon_footer_html');
						?>
						<div>Theme <a href="https://github.com/solstice23/argon-theme" target="_blank"><strong>Argon</strong></a><?php if (get_option('argon_hide_footer_author') != 'true') {echo " By solstice23"; }?></div>
					</footer>
				</main>
			</div>
		</div>
		<script src="<?php echo $GLOBALS['assets_path']; ?>/argontheme.js?v<?php echo $GLOBALS['theme_version']; ?>"></script>
		<?php if (get_option('argon_math_render') == 'mathjax3') { /*Mathjax V3*/?>
			<script>
				window.MathJax = {
					tex: {
						inlineMath: [["$", "$"], ["\\\\(", "\\\\)"]],
						displayMath: [['$$','$$']],
						processEscapes: true,
						packages: {'[+]': ['noerrors']}
					},
					options: {
						skipHtmlTags: ['script', 'noscript', 'style', 'textarea', 'pre', 'code'],
						ignoreHtmlClass: 'tex2jax_ignore',
						processHtmlClass: 'tex2jax_process'
					},
					loader: {
						load: ['[tex]/noerrors']
					}
				};
			</script>
			<script src="<?php echo get_option('argon_mathjax_cdn_url') == '' ? '//cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml-full.js' : get_option('argon_mathjax_cdn_url'); ?>" id="MathJax-script" async></script>
		<?php }?>
		<?php if (get_option('argon_math_render') == 'mathjax2') { /*Mathjax V2*/?>
			<script type="text/x-mathjax-config" id="mathjax_v2_script">
				MathJax.Hub.Config({
					messageStyle: "none",
					tex2jax: {
						inlineMath: [["$", "$"], ["\\\\(", "\\\\)"]],
						displayMath: [['$$','$$']],
						processEscapes: true,
						skipTags: ['script', 'noscript', 'style', 'textarea', 'pre', 'code']
					},
					menuSettings: {
						zoom: "Hover",
						zscale: "200%"
					},
					"HTML-CSS": {
						showMathMenu: "false"
					}
				});
			</script>
			<script src="<?php echo get_option('argon_mathjax_v2_cdn_url') == '' ? '//cdn.jsdelivr.net/npm/mathjax@2.7.5/MathJax.js?config=TeX-AMS_HTML' : get_option('argon_mathjax_v2_cdn_url'); ?>"></script>
		<?php }?>
		<?php if (get_option('argon_math_render') == 'katex') { /*Katex*/?>
			<link rel="stylesheet" href="<?php echo get_option('argon_katex_cdn_url') == '' ? '//cdn.jsdelivr.net/npm/katex@0.11.1/dist/' : get_option('argon_katex_cdn_url'); ?>katex.min.css">
			<script src="<?php echo get_option('argon_katex_cdn_url') == '' ? '//cdn.jsdelivr.net/npm/katex@0.11.1/dist/' : get_option('argon_katex_cdn_url'); ?>katex.min.js"></script>
			<script src="<?php echo get_option('argon_katex_cdn_url') == '' ? '//cdn.jsdelivr.net/npm/katex@0.11.1/dist/' : get_option('argon_katex_cdn_url'); ?>contrib/auto-render.min.js"></script>
			<script>
				document.addEventListener("DOMContentLoaded", function() {
					renderMathInElement(document.body,{
						delimiters: [
							{left: "$$", right: "$$", display: true},
							{left: "$", right: "$", display: false},
							{left: "\\(", right: "\\)", display: false}
						]
					});
				});
			</script>
		<?php }?>

		<?php if (get_option('argon_enable_code_highlight') == 'true') { /*Highlight.js*/?>
			<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/wf-ping/argon.fanfine.cn@v1.3.5/assets/vendor/highlight/styles/<?php echo get_option('argon_code_theme') == '' ? 'vs2015' : get_option('argon_code_theme'); ?>.css">
		<?php }?>

	</div>
</div>
<?php 
	wp_enqueue_script("argonjs", $GLOBALS['assets_path'] . "/assets/js/argon.min.js", null, $GLOBALS['theme_version'], true);
?>
<?php wp_footer(); ?>


<!--全页特效开始-->
<!-- 亮 暗 切换樱花、雪花切换 -->
<script src="https://cdn.jsdelivr.net/gh/huangwb8/bloghelper@latest/js/mobile-detect.js"></script>
<script type="text/javascript">
    // 设备检测
    var md = new MobileDetect(window.navigator.userAgent);
    // 仅在PC上生效，手机/平板不生效
    if (!md.phone() && !md.tablet()) {
        // 当页面加载完成后执行
        jQuery(document).ready(function ($) {
            
            function loadEffect() {
                // 检查 <html> 标签是否包含 'darkmode' 类
                const isDarkMode = $('html').hasClass('darkmode');
                // 清除已加载的特效（防止重复加载）
                removeExistingEffects();

                if (isDarkMode) {
                    // 暗黑模式：加载雪花特效
                    $.getScript("https://cdn.jsdelivr.net/gh/wf-ping/js_hub@main/snow.js", function () {
                        createSnow("", 40);  // 初始化雪花特效
                    });
                } else {
                    // // 非暗黑模式：加载樱花特效
                    $.getScript("https://cdn.jsdelivr.net/gh/wf-ping/js_hub@main/sakura.js", function () {
                        startSakura();  // 初始化樱花特效
                    });
                }

                // 加载鼠标移动的仙女棒特效（适用于所有模式）
                $.getScript("https://cdn.jsdelivr.net/gh/huangwb8/bloghelper@latest/mouse/halo-dream/fairyDustCursor.min.js");
            }

            // 移除已加载的特效（避免模式切换时特效重叠）
            function removeExistingEffects() {
                // 停止雪花特效
                if (typeof removeSnow === 'function') removeSnow();
                // 停止樱花特效
                if (typeof removeSakura === 'function') removeSakura();
                // 移除所有相关的元素
                $('img[data-effect="snow"]').remove();
                $('div[data-effect="sakura"]').remove();
            }

            // 初始加载特效
            loadEffect();

            // 监听模式切换按钮的点击事件
            const themeToggleButton = $('#fabtn_toggle_darkmode'); // 使用按钮的 ID 选择器
            if (themeToggleButton.length) {
                themeToggleButton.on('click', function () {
                    // 使用 setTimeout 确保切换效果完成后重新加载特效
                    setTimeout(loadEffect, 300);
                });
            }
        });
    }
</script>
 
 
<!--网站输入效果-->
<script src="https://cdn.jsdelivr.net/gh/huangwb8/bloghelper@latest/js/input-with-fire.js"></script>
 
<!-- 鼠标点击特效 -->
 <script type="text/javascript"> 
var a_idx = 0; 
jQuery(document).ready(function($) { 
    $("body").click(function(e) { 
        var a = new Array("❤富强❤", "❤民主❤", "❤文明❤", "❤和谐❤", "❤自由❤", "❤平等❤", "❤公正❤" ,"❤法治❤", "❤爱国❤", "❤敬业❤", "❤诚信❤", "❤友善❤"); 
        var b = new Array("red","blue","yellow","green","pink","purple","orange");
        var $i = $("<span/>").text(a[a_idx]); 
        a_idx = (a_idx + 1) % a.length; 
        b_idx = (a_idx+1)%7;/* 七中颜色变色 */
        var x = e.pageX, 
        y = e.pageY; 
        $i.css({ 
            "z-index": 9999, 
            "top": y - 20, 
            "left": x, 
            "position": "absolute", 
            "font-weight": "bold", 
            "color": b[b_idx]
        }); 
        $("body").append($i); 
        $i.animate({ 
            "top": y - 180, 
            "opacity": 0 
        }, 
        1500, 
        function() { 
            $i.remove(); 
        }); 
    }); 
}); 
</script>
 
<!--鼠标指针变化 开始-->
<style type="text/css">
.main-content img,body{cursor:url(https://cdn.jsdelivr.net/gh/huangwb8/bloghelper@latest/mouse/halo-dream/cursor/breeze/Arrow.cur),auto}.actions>div,.expand-done,.main-content figure>figcaption div,.navbar-above .navbar-nav .item,.navbar-searchicon,.navbar-slideicon,.photos .picture-details,.widget .ad-tag .click-close,a,button{cursor:url(https://cdn.jsdelivr.net/gh/huangwb8/bloghelper@latest/mouse/halo-dream/cursor/breeze/Hand.cur),auto}blockquote,code,h1,h2,h3,h4,h5,h6,hr,input[type=text],li,p,td,textarea,th{cursor:url(https://cdn.jsdelivr.net/gh/huangwb8/bloghelper@latest/mouse/halo-dream/cursor/breeze/IBeam.cur),auto}
</style>

 
<!--春节灯笼开始-->
<link href="https://cdn.jsdelivr.net/gh/huangwb8/bloghelper@latest/css/deng.css" rel="stylesheet">
<div class="deng-box">
<div class="deng">
<div class="xian"></div>
<div class="deng-a">
<div class="deng-b"><div class="deng-t">春节</div></div>
</div>
<div class="shui shui-a"><div class="shui-c"></div><div class="shui-b"></div></div>
</div>
</div>
 
<div class="deng-box1">
<div class="deng">
<div class="xian"></div>
<div class="deng-a">
<div class="deng-b"><div class="deng-t">快乐</div></div>
</div>
<div class="shui shui-a"><div class="shui-c"></div><div class="shui-b"></div></div>
</div>
</div>
<!-- 全页特效开始 -->

</body>

<?php echo get_option('argon_custom_html_foot'); ?>

</html>
