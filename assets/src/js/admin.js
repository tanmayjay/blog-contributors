(function($) {
    const jBlogContributorsAdmin = {
        init: () => {
            jBlogContributorsAdmin.initSelect2();
        },
        initSelect2: () => {
            $(".jbc-checklist").select2({
                width: "100%",
            });
        }
    }
    $(document).ready(jBlogContributorsAdmin.init);
})(jQuery);
