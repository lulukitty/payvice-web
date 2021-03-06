$(document).ready(function() {
    $("#smartwizard").on("showStep", function(t, n, a, e, r) {
        "first" === r ? $("#prev-btn").addClass("disabled") : "final" === r ? $("#next-btn").addClass("disabled") : ($("#prev-btn").removeClass("disabled"), $("#next-btn").removeClass("disabled"))
    });
    var n = $("<button></button>").text("Cancel").addClass("btn btn-danger").on("click", function() {
            $("#smartwizard").smartWizard("reset")
        });
    $("#smartwizard").smartWizard({
        selected: 0,
        theme: "default",
        transitionEffect: "fade",
        showStepURLhash: !0,
        toolbarSettings: {
            
            toolbarButtonPosition: "end",
            toolbarExtraButtons: [n]
        }
    }), $("#reset-btn").on("click", function() {
        return $("#smartwizard").smartWizard("reset"), !0
    }), $("#prev-btn").on("click", function() {
        return $("#smartwizard").smartWizard("prev"), !0
    }), $("#next-btn").on("click", function() {
        return $("#smartwizard").smartWizard("next"), !0
    }), $("#theme_selector").on("change", function() {
        return $("#smartwizard").smartWizard("theme", $(this).val()), !0
    }), $("#theme_selector").change()
});