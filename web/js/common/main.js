/**
 * Created by sergey on 17.05.16.
 */

$(document).ready(function() {
    $('#eventhandler-event_model').change(function () {
       if ($(this).val() != '') {
           var model = $("#eventhandler-event_model :selected").text();
           $.ajax({
               type: "GET",
               url: "?r=event-handler/get-events&model="+model,
               success: function(data) {
                   var sel = $('#eventhandler-event_name');
                   sel.html("");
                   $.each(data, function(i, v) {
                       sel.append("<option value='"+v+"'>"+v+"</option>");

                   })
               }
           });
           $(".model-params").show();
       } else {
           $(".model-params").hide();
       }

    });

    $('#eventhandler-template').focusout(function() {
        var text = $(this).val();
        var re = /\{\{([A-Za-z0-9]+)\}\}/g;
        var params_wrap = $(".params-wrap");
        params_wrap.html("");
        var param;
        while((param = re.exec(text)) != null) {
            if (params_wrap.find(".param-"+param[1]).length) continue;
            params_wrap.append(
                "<div class='param-"+param[1]+"'><b>"+param[1]+"</b>:" +
                "<select name='param-"+param[1]+"-type' class='param-type'>" +
                    "<option value='const'>Константа</option>" +
                    "<option value='model'>Атрибут модели</option>" +
                "</select>" +
                "<span class='param-holder'>" +
                    "<input name='param-"+param[1]+"' class='param-const'>" +
                "</span>"+
                "</div>");
        };
        $(".param-type").change(function() {
            var v = $(this).find(":selected").val();
            var p = $(this).parent();
            var param_name = p.find("b").text();
            var h = $(this).parent().find('.param-holder');
            h.html("");
            if (v == 'model') {
                var model = $("#eventhandler-event_model :selected").text();
                $.ajax({
                    type: "GET",
                    url: "?r=event-handler/get-model-attributes&model=" + model,
                    success: function (data) {
                        h.append("<select name='param-"+param_name+"'></select>");
                        var sel = h.find('select');
                        $.each(data, function (i, v) {
                            sel.append("<option value='" + v + "'>" + v + "</option>");

                        });
                    }
                });
            } else if (v == 'const') {
                h.append("<input name='param-"+param_name+"' class='param-const'>");
            }
        });
    });
    $(".field-eventhandler-recipient").hide();
    $(".model-params").hide();

    $("select[name=recipient_type]").change(function() {
        var v = $(this).find(":selected").val();
        var sel = $('#eventhandler-recipient');
        sel.html("");
        switch (v) {
            case '0':
                $(".field-eventhandler-recipient").hide();
                sel.append("<option value='0'>Все</option>");
                break;
            case '1':
                $(".field-eventhandler-recipient").show();
                $.ajax({
                    type: "GET",
                    url: "?r=event-handler/get-users",
                    success: function(data) {
                        sel.html("");
                        $.each(data, function(i, v) {
                            sel.append("<option value='"+i+"'>"+v+"</option>");

                        })
                    }
                });
                break;
            case '2':
                var model = $("#eventhandler-event_model :selected").text();
                $(".field-eventhandler-recipient").show();
                $.ajax({
                    type: "GET",
                    url: "?r=event-handler/get-recipients&model="+model,
                    success: function(data) {
                        var sel = $('#eventhandler-recipient');
                        sel.html("");
                        $.each(data, function(i, v) {
                            sel.append("<option value='"+v+"'>"+v+"</option>");

                        })
                    }
                });
        }
    });

    $('.notify-read').click(function () {
        var href = $(this).attr('href');
        $.get(href);
        $(this).parent().parent().removeClass('alert-info').addClass('alert-success');
        $(this).remove();
        return false;
    });



});
