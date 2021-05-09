$(function() {

    function cb(start, end) {
        if(start.format('MMMM D, YYYY') == end.format('MMMM D, YYYY')) {
            $('#reportrange span').html('Display records: ' + start.format('MMMM D, YYYY'));
        }else {
            $('#reportrange span').html( 'Display records from ' + start.format('MMMM D, YYYY') + ' to ' + end.format('MMMM D, YYYY'));
        }
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        alwaysShowCalendars: true,
        autoApply: false,
        linkedCalendars: false,
        minDate: start,
        ranges: {
           'Lifetime': [start, moment()],
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);
    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        start = picker.startDate;
        end = picker.endDate;

        table.ajax.reload();
    });

    cb(start, end);
});

        