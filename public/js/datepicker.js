$(function($) {
      $('#datepicker1').datepicker({
        numberOfMonths: 1, 
        firstDay: 1,
            dateFormat: 'dd-mm-yy', 
            minDate: '0', 
            maxDate: '+2Y',
                  onSelect: function(dateStr) {
                        var min = $(this).datepicker('getDate');
                       
            }});
      
});
  