//step wizard
$(function() {
    let form = $('#default')
    form.stepy({
        backLabel: 'Previous',
        block: true,
        nextLabel: 'Next',
        titleClick: true,
        titleTarget: '.stepy-tab',
        next: function(index, totalSteps) {
            // /scroll back up
            $("html, body").animate({
                scrollTop: 0
            }, 500); 
        },
        validate:false,
        // validateOptions:{
        //     errorPlacement: function(error, element) {},
        //     highlight: function(element, errorClass) {
        //         $('.alert').removeClass('hidden');
        //         $('.alert').fadeOut(1000,function() {
        //             $('.alert').fadeIn();
        //         });
        //     },
        //     unhighlight: function(element, errorClass) {
        //         $('.alert').addClass('hidden');
        //     }
        // }
    });
});