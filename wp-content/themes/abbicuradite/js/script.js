jQuery(function($) {

    quiz_valutazione = jQuery('.quiz .valutazione');
    quiz_valutazione.find('.wpcf7-list-item-label').on("click", function(){
        col_parent = jQuery(this).closest(".col-question");

        if(!col_parent.is(':last-child')){
            next_col = col_parent.next();
            next_col.fadeTo(300, 1);
            $('html, body').scrollTop(next_col.offset().top-200);
        }
        fieldset = col_parent.closest("fieldset");
        if(fieldset.hasClass("field-anagrafica")){
            if(col_parent.is(':last-child')){
                console.log('last field-anagrafica');
                jQuery(".section-title-valutazione").fadeIn(300);
                jQuery(".section-form-valutazione").fadeIn(300);
                $('html, body').scrollTop(jQuery(".section-title-valutazione").offset().top-200);
            }
        }
        else if(fieldset.hasClass("field-valutazione")){
            if(col_parent.is(':last-child')){
                console.log('last field-valutazione');
                section_button = jQuery(".section-button");
                section_button.fadeIn(300);
                $('html, body').scrollTop(section_button.offset().top-200);
            }
        }
    });

    //show orange popup on the right
    $(window).scroll(function() {
        if ($(this).scrollTop() > 813){
            $( ".show-compilare-btn" ).addClass("visible");
        }else{
            $( ".show-compilare-btn" ).removeClass("visible");
        }
    });
    //dropdown hover menu Area rischio
    $(".dropdown").hover(function(){
        var dropdownMenu = $(this).children(".dropdown-menu");
        if(dropdownMenu.is(":visible")){
            dropdownMenu.parent().toggleClass("open");
        }
    });

    //close modal document in page aree di rischio
    $(".closeDocModal").click(function () {
        $('.docModal').modal('hide');
    });

    /*begin stop slide auto carousel test*/
    $('#myCarousel').carousel({
        interval: false,
    });
    jsonObj = [];
    //seach sector register and edit profil
    $(".searchSector").select2();


    //Checked only one answer in test bloc
    $(".test  input[type='radio']").click(function(){
        console.log("click answer");
        var idQ = $(this).closest("div.risposte").attr("id");
        $(".answer.test."+idQ).each(function(key){
            $(this).removeAttr("checked");
        });
        $(this).attr({"checked":true}).prop({"checked":true});
    });
    //Send form test rischi
    $(".btn-send").click(function(event) {
        event.preventDefault();
        $('.btn-send').attr('disabled',true);
        var form= $("#form-questionario");
        var ajaxurl = form.data("url");
        //get all radio checked
        var idUser = $('#idUser').val();
        var idTest = $('#idTest').val();

        $('.request input[type=radio]:checked').each(function (index) {
            var answerValue = $(this).val();
            item = {};
            item ["idQuestion"] = $(this).attr('data-id');
            item["valueQuestion"] = $(this).attr('data-valueQuestion');
            item ["idAnswer"] = $(this).attr('data-idAnswer');
            item ["valueAnswer"] = answerValue;
            jsonObj.push(item);
        });

        $.ajax({
            method: "POST",
            url: ajaxurl,
            data: {
                userId:idUser,
                idTest:idTest,
                data: JSON.stringify(jsonObj),
                action: "add_test_user"
            },
            success: function (response)
            {
                var result = JSON.parse(response);
                $('.btn-send').removeAttr('disabled');
                 window.location.href = result.redirect;
            },
            error: function(){
                $('.btn-send').removeAttr('disabled');
            }
        });
    });
//End Send form test rischi

    //Send form Valutazione test
    var noError = $('.question .msgError').hide();
    $(".btn-send-valutazione").click(function(event) {
        event.preventDefault();
        var jsonObj = [];
        var jsonObjAnagrafici = [];
        var idQ = [];
        var idQValutazione  = [];
        var form= $("#form-valutazione");
        var ajaxurl = form.data("url");
        //get all radio checked
        var idUser = $('#idUser').val();
        var idPostType = $(this).attr("data-postType");
        let json =  {
            "anagrafiche": [],
            "valutazioni": []
        };
        $('.anagrafici:checked').each(function (index) {
            var id =  $(this).attr('data-idq');
            var answerValue = $(this).val();
            item = {};
            item ["idQuestion"] = id;
            item ["idAnswer"] = answerValue;
            json.anagrafiche.push(item);
            idQ.push(id);
        });
        //show error if exist anagrafici
        $('.question .anagrafici').each(function() {
            var id =  $(this).attr('data-idq');
            if($.inArray(id, idQ) != -1) {
                $('div.error'+id).hide();
            } else {
                console.log('anagrafici'+id);
                $('div.anagrafici.error'+id).show();
            }
        });
        // chech error valutazione
        $('.valutazione:checked').each(function (index) {
            var id =  $(this).attr('data-idq');
            var answerValue = $(this).val();
            var color = $(this).attr('data-color');
            item = {};
            item ["idQuestion"] = index;
            item ["idAnswer"] = answerValue;
            item ["color"] = color;
            json.valutazioni.push(item);
            idQValutazione.push(id);
        });
        $('.question .valutazione').each(function() {
            var id =  $(this).attr('data-idq');
            if($.inArray(id, idQValutazione) != -1) {
                $('.valutazione.error'+id).hide();
            } else {
                $('.valutazione.error'+id).show();
            }
        });
        if($(".msgError").is(":visible")){
            //scrollTo(".msgError");
            var $container = $('html, body');
            var $scrollTo = $(".msgError").first().closest('.question');
            $container.scrollTop($scrollTo.offset().top-200);


            console.log("The msgError  is visible.");
        } else{
            $('.btn-send-valutazione').attr('disabled',true);
            console.log("The error  is hidden.");
            $.ajax({
                method: "POST",
                url: ajaxurl,
                data: {
                    userId:idUser,
                    idPostType:idPostType,
                    data: JSON.stringify(json),
                    action: "add_test_valutazione_user"
                },
                success: function (response)
                {
                    var result = JSON.parse(response);
                    $('.btn-send-valutazione').removeAttr('disabled');
                    window.location.href = result.redirect;
                    console.log("test finish");
                },
                error: function(){
                    alert('error!');
                }
            });
        }
    });
//End Send form Valutazione rischi


//Begin count slide carousel
    $('.btn-detail-documento').click(function(){
        var area = $(this).attr("data-area");
        var tax = $(this).attr("data-tax");
        console.log(tax);
        var totalItems = $('#'+area).attr('data-count');
        var currentIndex = $('#'+area+' div.active').index() + 1;
        $('.numCarousel').html('<button className="carousel-control-prev " class="carouselbtn" type="button" data-bs-target="#testCarousel'+tax+'" data-bs-slide="prev">'+
            '<span class="fw-bold"> < </span></button>' + ' '+currentIndex + ' / ' + totalItems +' '+
           '<button class="text-center text-center carouselbtn"  type="button" data-bs-target="#testCarousel'+tax+'" data-bs-slide="next">'+
                '<span class="fw-bold"> > </span>'+
            '</button>');
    });

    $('.carousel').on('slid.bs.carousel', function(f) {
        var totalItems = $(this).attr('data-count');
        var area = $(this).attr('id');
        var tax = $(this).attr("data-tax");
        var currentIndex = $('#'+area+' div.active').index() + 1;
        $('.numCarousel').html('<button className="" class="carouselbtn" type="button" data-bs-target="#testCarousel'+tax+'" data-bs-slide="prev">'+
            '<span class="fw-bold" > < </span></button>' + ' '+currentIndex + ' / ' + totalItems + ' '+
            '<button class=" text-center text-center carouselbtn"  type="button" data-bs-target="#testCarousel'+tax+'" data-bs-slide="next">'+
            '<span class="fw-bold" > > </span>'+
            '</button>');
    });


    //modal studio area studio
    const myModal = new bootstrap.Modal(document.getElementById('myModal'), {});
    const trigg = document.querySelector('#modal-trigger');
    function showModal(el){
        el.show();
    }

    // Event 1:  show after 1 second:
    setTimeout(function() {
        showModal(myModal);
        trigg.style.display = 'inline-block';
    }, 1000)

    // Event 2: show on click:
    trigg.addEventListener('click', function(){
        showModal(myModal);
    });
});


