document.addEventListener("DOMContentLoaded", function () {
  var swiper = new Swiper(".swiper-container", {
    loop: true,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    slidesPerView: 1,
    spaceBetween: 30,
  });
});

//list

(function ($) {
  $(document).ready(function () {
    $(".elementor-widget-blog_category_list_widget select").on(
      "change",
      function () {
        let selectedCategories = $(this).val();
        let displayContainer = $(".selected-categories-container");
        displayContainer.empty(); // Clear previous entries
        $.each(selectedCategories, function (index, categoryId) {
          let categoryName = $('option[value="' + categoryId + '"]').text();
          let backgroundColor = $(
            '[data-setting="background_color_' + categoryId + '"]'
          ).val();
          let borderColor = $(
            '[data-setting="border_color_' + categoryId + '"]'
          ).val();
          let fontColor = $(
            '[data-setting="font_color_' + categoryId + '"]'
          ).val();
          displayContainer.append(
            '<div class="selected-category" style="background-color: ' +
              backgroundColor +
              "; border-color: " +
              borderColor +
              "; color: " +
              fontColor +
              ';">' +
              categoryName +
              "</div>"
          );
        });
      }
    );
  });
})(jQuery);
