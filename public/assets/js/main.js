$(document).ready(function () {
    if ($("input[name='tasks[enabled]']").is(':checked')) {
        let $selectDirectory = $("select[name=\'tasks[directory]\']");
        $('.loader.tasks').css('display', 'flex');
        $.ajax({
            method: "GET",
            url: $("select[name=\'tasks[provider]\'] option:selected").data('value'),
        }).done(function (data) {
            $("select[name=\'tasks[directory]\'] option").each(function (index) {
                $(this).remove();
            });
            $.each(data, function (index, value) {
                let o = new Option(value.title, value.id);
                $(o).html(value.title);
                $selectDirectory.append(o);
            });
            $selectDirectory.prop('disabled', false).selectpicker('refresh').selectpicker('val', config.tasks.directory);
            $('.loader.tasks').css('display', 'none');
        });
    } else {
        $("select[name=\'tasks[directory]\']").prop('disabled', true).selectpicker('refresh');
    }

    if ($("input[name='air[enabled]']").is(':checked')) {
        let $selectStation = $("select[name=\'air[station]\']");
        $('.loader.air').css('display', 'flex');
        $.ajax({
            method: "GET",
            url: $selectStation.data('url'),
        }).done(function (data) {
            $("select[name=\'air[station]\'] option").each(function (index) {
                $(this).remove();
            });
            $.each(data, function (index, value) {
                let o = new Option(value, index);
                $(o).html(value);
                $selectStation.append(o);
            });
            $selectStation.prop('disabled', false).selectpicker('refresh').selectpicker('val', config.air.station);
            $('.loader.air').css('display', 'none');
        });
    } else {
        $("select[name=\'air[station]\']").prop('disabled', true).selectpicker('refresh');
    }

    if ($("select[name='news[rss]']").val() == -1) {
        $("input[name='news[rss]']").prop('disabled', false);
    } else {
        $("input[name='news[rss]']").prop('disabled', true);
    }
});

$(document).on('click', '#force-refresh', function (e) {
    e.preventDefault();
    $.ajax({
        method: "GET",
        url: $(this).attr('href'),
    }).done(function (data) {
        alert('Synchronizacja uruchomiona');
    });
});

//TASKS
$(document).on('change', "input[name='tasks[enabled]'], select[name='tasks[provider]']", function () {
    if ($("input[name='tasks[enabled]']").is(':checked')) {
        let $selectDirectory = $("select[name=\'tasks[directory]\']");
        $('.loader.tasks').css('display', 'flex');
        $.ajax({
            method: "GET",
            url: $("select[name=\'tasks[provider]\'] option:selected").data('value'),
        }).done(function (data) {
            $("select[name=\'tasks[directory]\'] option").each(function (index) {
                $(this).remove();
            });
            $.each(data, function (index, value) {
                let o = new Option(value.title, value.id);
                $(o).html(value.title);
                $selectDirectory.append(o);
            });
            $selectDirectory.prop('disabled', false).selectpicker('refresh');
            $('.loader.tasks').css('display', 'none');
        });
    } else {
        $("select[name=\'tasks[directory]\']").prop('disabled', true).selectpicker('refresh');
    }
});
//AirQuality
$(document).on('change', "input[name='air[enabled]']", function () {
    if ($(this).is(':checked')) {
        let $selectStation = $("select[name=\'air[station]\']");
        $('.loader.air').css('display', 'flex');
        $.ajax({
            method: "GET",
            url: $selectStation.data('url'),
        }).done(function (data) {
            $("select[name=\'air[station]\'] option").each(function (index) {
                $(this).remove();
            });
            $.each(data, function (index, value) {
                let o = new Option(value, index);
                $(o).html(value);
                $selectStation.append(o);
            });
            $selectStation.prop('disabled', false).selectpicker('refresh').selectpicker('val', config.air.station);
            $('.loader.air').css('display', 'none');
        });
    } else {
        $("select[name=\'air[station]\']").prop('disabled', true).selectpicker('refresh');
    }
});
//RSS
$(document).on('change', "select[name='news[rss]']", function () {
    if ($(this).val() == -1) {
        $("input[name='news[rss]']").prop('disabled', false);
    } else {
        $("input[name='news[rss]']").prop('disabled', true);
    }
});
