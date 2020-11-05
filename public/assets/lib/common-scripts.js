

var Script = function() {
  //    sidebar dropdown menu auto scrolling

  jQuery('#sidebar .sub-menu > a').click(function() {
    var o = ($(this).offset());
    diff = 250 - o.top;
    if (diff > 0)
      $("#sidebar").scrollTo("-=" + Math.abs(diff), 500);
    else
      $("#sidebar").scrollTo("+=" + Math.abs(diff), 500);
  });



  //    sidebar toggle

  $(function() {
    function responsiveView() {
      var wSize = $(window).width();
      if (wSize <= 768) {
        $('#container').addClass('sidebar-close');
        $('#sidebar > ul').hide();
          $('.tooltips').removeClass("fa-times").addClass("fa-bars")
          $("#mobi").addClass("fas fa-sign-out-alt");
          $("#mobi").empty("WYLOGUJ");
      }

      if (wSize > 768) {
        $('#container').removeClass('sidebar-close');
        $('#sidebar > ul').show();
        $("#mobi").text("WYLOGUJ");
        $("#mobi").removeClass("fas fa-sign-out-alt");

      }
    }
    $(window).on('load', responsiveView);
    $(window).on('resize', responsiveView);
  });

  $('.tooltips').click(function() {
    if ($('#sidebar > ul').is(":visible") === true) {
      $('#main-content').css({
        'margin-left': '0px'
      });
      $('#sidebar').css({
        'margin-left': '-210px'
      });
      $('#sidebar > ul').hide();
      $("#container").addClass("sidebar-closed");
      $('.tooltips').removeClass("fa-times").addClass("fa-bars")

    } else {
      $('#main-content').css({
        'margin-left': '210px'
      });
      $('#sidebar > ul').show();
      $('#sidebar').css({
        'margin-left': '0'
      });
      $("#container").removeClass("sidebar-closed");
      $('.tooltips').removeClass("fa-bars").addClass("fa-times")
    }
  });
  // custom scrollbar
  $("#sidebar").niceScroll({
    styler: "fb",
    cursorcolor: "#4ECDC4",
    cursorwidth: '3',
    cursorborderradius: '10px',
    background: '#404040',
    spacebarenabled: false,
    cursorborder: ''
  });

  //  $("html").niceScroll({styler:"fb",cursorcolor:"#4ECDC4", cursorwidth: '6', cursorborderradius: '10px', background: '#404040', spacebarenabled:false,  cursorborder: '', zindex: '1000'});

  // widget tools

  jQuery('.panel .tools .fa-chevron-down').click(function() {
    var el = jQuery(this).parents(".panel").children(".panel-body");
    if (jQuery(this).hasClass("fa-chevron-down")) {
      jQuery(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
      el.slideUp(200);
    } else {
      jQuery(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
      el.slideDown(200);
    }
  });

  jQuery('.panel .tools .fa-times').click(function() {
    jQuery(this).parents(".panel").parent().remove();
  });


  //    tool tips

  $('.tooltips').tooltip();

  //    popovers

  $('.popovers').popover();



  // custom bar chart

  if ($(".custom-bar-chart")) {
    $(".bar").each(function() {
      var i = $(this).find(".value").html();
      $(this).find(".value").html("");
      $(this).find(".value").animate({
        height: i
      }, 2000)
    })
  }

}();

jQuery(document).ready(function( $ ) {

    // Go to top
    $('.go-top').on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({scrollTop : 0},500);
    });
});


$(document).on('change click', '.set-feature-active', function() {
    let active = 0;
    if(this.checked){
       active = 1;
    }
    $.post( $(this).data('href')+"/"+active, {
        _token: $('meta[name="csrf-token"]').attr('content')
    }).done(function( data ) {
        console.log('OK');
    });
})

$(document).on('click', '.start_configuration', function(e) {
    e.preventDefault();
    var $el = $(this);
    var $parent = $el.parents('.darkblue-panel');
    var $configuration_box =  $parent.find('.feature-configuration');
    $.get($(this).attr('href'), function( data ) {
        $configuration_box.html(data);
        $configuration_box.addClass('active');
        $configuration_box.find('select.selectpicker').selectpicker({"container":"body", "size":10, "virtualScroll":200});
        $(".do-nicescrol").niceScroll(".scroll-wrap")
    });
})

$(document).on('submit', '.send_configuration', function(e) {
    e.preventDefault();
    var $el = $(this);
    var $parent = $el.parents('.darkblue-panel');
    var $configuration_box =  $parent.find('.feature-configuration');
    $.post($el.attr('action'), $el.serializeArray()).done(function( data ) {
        $toast = $('.base_toast').clone();
        $toast.find('.toast-header strong').html(data.message);
        $toast.removeClass().addClass('toast').appendTo('#toast_container').toast('show');
        $configuration_box.removeClass('active');
    });
})

$(document).on('click', '.return_configuration', function(e) {
    e.preventDefault();
    var $el = $(this);
    var $parent = $el.parents('.darkblue-panel');
    var $configuration_box = $parent.find('.feature-configuration');
    $configuration_box.removeClass('active');
})

$(document).on('hidden.bs.toast', '.toast', function () {
    $(this).remove();
})

// NEWS
$(document).on('change', "select[name='data[rss]']", function () {
    if ($(this).val() == -1) {
        $("input[name='data[rss]']").prop('disabled', false);
    } else {
        $("input[name='data[rss]']").prop('disabled', true);
    }
});
// TASKS
$(document).on('change', ".tasks select[name='data[provider]']", function () {
    getTasksDirectory()
});

function getTasksDirectory(selected = '')
{
    let $selectDirectory = $(".tasks select[name=\'data[directory]\']");
    $('.loader.tasks').css('display', 'flex');
    $.ajax({
        method: "GET",
        url: $("select[name=\'data[provider]\'] option:selected").data('value'),
    }).done(function (data) {
        $("select[name=\'data[directory]\'] option").each(function (index) {
            $(this).remove();
        });
        console.log(data);
        if(data.status == 'error') {
            alert(data.data);
        } else {
            $.each(data.data, function (index, value) {
                let o = new Option(value.title, value.id);
                $(o).html(value.title);
                $selectDirectory.append(o);
            });
            $selectDirectory.prop('disabled', false).selectpicker('refresh');
            if(selected) {
                $selectDirectory.selectpicker('val', selected);
            }
        }
        $('.loader.tasks').css('display', 'none');
    });
}


function setPageMode(url) {
    let mode = 'light-mode';
    $('body').toggleClass('dark-mode');
    if($('body').hasClass('dark-mode')) {
        mode = 'dark-mode';
        $('.night .ico').removeClass("fas").addClass("far")
    } else {
        $('.night .ico').removeClass("far").addClass("fas")
    }
    $.post(url+"/"+mode, {
        _token: $('meta[name="csrf-token"]').attr('content')
    })
}
