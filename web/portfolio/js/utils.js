//Smooth scrolling with links
$("a[href*=\\#]").on("click", function(event) {
  event.preventDefault();
  $("html,body").animate({ scrollTop: $(this.hash).offset().top }, 800);
});