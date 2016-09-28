(function ($, window, undefined) {
  'use strict';

  var $doc = $(document),
      win = $(window),
      Modernizr = window.Modernizr,
      jstz_timezone = jstz.determine(),
      name_timezone = jstz_timezone.name(),
      offset_timezone = jstz_timezone.offset(),
      offset_text_timezone = offset_timezone.toString();

  var TimeZone = TimeZone || {};
  
  TimeZone = {
    init: function() {
      var self = this;
      if (offset_timezone >= 0){
        offset_text_timezone = "UTC+" + offset_text_timezone;
      }else{
        offset_text_timezone = "UTC" + offset_text_timezone;          
      }

      self.addAdminAutoSelect();
      self.changeDatesTimezone();
    },
    addAdminAutoSelect: function() {
      var admin_select = $("#_ibm_event_time_zone"),
          original_post_status = $("#original_post_status");
      if (admin_select.length > 0 && original_post_status.length > 0 && original_post_status.val() == "auto-draft"){
        if ($("#_ibm_event_time_zone option[value='" + name_timezone + "']").length > 0){
          admin_select.val(name_timezone);
        }else if($("#_ibm_event_time_zone option[value='" + offset_text_timezone + "']").length > 0){
          admin_select.val(offset_text_timezone);
        }
      }
    },
    getCurrentTimezoneDateUTC: function(that, key){
      var post_timezone_date = $(that).attr('data-timezone-date' + key);
      var post_timezone_offset = $(that).attr('data-timezone-offset');
      var post_timezone_offset_def = $(that).attr('data-timezone-offset-def');
      post_timezone_offset_def = 0;
      var date_post = new Date(post_timezone_date);     
      var date_utc_def = new Date(date_post.getTime() - ((post_timezone_offset_def) * 60000));
      var date_utc = new Date(date_utc_def.getTime() - ((post_timezone_offset) * 60000));

      return date_utc; 
    },
    getCurrentTimezoneDate: function(that, key){
      var post_timezone_date = $(that).attr('data-timezone-date' + key);
      var post_timezone_offset = $(that).attr('data-timezone-offset');
      var post_timezone_offset_def = $(that).attr('data-timezone-offset-def');
      post_timezone_offset_def = 0;

      var date_post = new Date(post_timezone_date);     
      var date_utc_def = new Date(date_post.getTime() - ((post_timezone_offset_def) * 60000));
      var date_utc = new Date(date_utc_def.getTime() - ((post_timezone_offset) * 60000));

      jstz_timezone = jstz.determine(date_utc),
      name_timezone = jstz_timezone.name(),
      offset_timezone = jstz_timezone.offset_dst(),
      offset_text_timezone = offset_timezone.toString();

      var date_current = new Date(date_utc.getTime() + (offset_timezone * 60000));  

      $(that).attr('data-timezone-date' + key + '-current-offset', offset_timezone);
      $(that).attr('data-timezone-date' + key + '-utc', date_utc);
      $(that).attr('data-timezone-date' + key + '-current', date_current);
      return date_current;
    },
    getCorrectText: function(that, date_current, post_timezone_type){
      var text = "";
      switch(post_timezone_type.toString()){
        case '1':
          text = $.format.date(date_current, "MMMM d, yyyy @ h:mm a");
          /*
          if ((offset_timezone / 60) >= 0) {
            text += " UTC+" + (offset_timezone / 60).toString();  
          }else{
            text += " UTC" + (offset_timezone / 60).toString();              
          }
          */
          var span_date_hosted_location = $(that).parent().parent().parent().find('.span_date_hosted_location');
          if ($.format.date(date_current, "MMMM d, yyyy") == span_date_hosted_location.html()) {
            span_date_hosted_location.css('display', 'none');
          }
        break;
        case '10':
          text = $.format.date(date_current, "h:mm a");
          if ((offset_timezone / 60) >= 0) {
            text += " UTC+" + (offset_timezone / 60).toString();  
          }else{
            text += " UTC" + (offset_timezone / 60).toString();              
          }
        break;
        case '2':
          var date_current_end = TimeZone.getCurrentTimezoneDate(that, '-end');        
          if ($.format.date(date_current, "mm") == "00"){
            text = $.format.date(date_current, "MMMM d, ha");
          }else{
            text = $.format.date(date_current, "MMMM d, h:mma");
          }
          if ($.format.date(date_current_end, "mm") == "00"){
            text += ' - ' + $.format.date(date_current_end, "ha");
          }else{
            text += ' - ' + $.format.date(date_current_end, "h:mma");
          }
          text += " UTC" + (offset_timezone / 60).toString();
        break;
        case '3':
          if ($.format.date(date_current, "mm") == "00"){
            text = $.format.date(date_current, "ha");
          }else{
            text = $.format.date(date_current, "h:mma");
          }
          text += " UTC" + (offset_timezone / 60).toString();
        break;
        case '4':
          text = TimeZone.getStartIn(date_current);
          text = "Event Starts In: " + text;
        break;
        case '5':
          text = "Beginning " + $.format.date(date_current, "MMMM d, yyyy");
        break;
        case '6':
          text = TimeZone.getRegisterForm(that, date_current);
        break;      
        case '7':
          text = TimeZone.getList(that, date_current);
        break;    
        case '8':
          text = TimeZone.getSideBarCalendar(that, date_current);
        break;    
        case '9':
          text = $.format.date(date_current, "MMMM d, yyyy");
        break;    
      }
      return text;
    },
    getSideBarCalendar: function(that, date_current){
      TimeZone.changeAddThisEvent(that);
      return "";      
    },
    getList: function(that, date_current){
      $(that).find('.date').html($.format.date(date_current, "dd MMM"));          
      $(that).find('.day').html($.format.date(date_current, "ddd")); 
      TimeZone.changeAddThisEvent(that);
      return "";      
    },
    changeAddThisEvent: function(that){
      var date_current_uct_end = TimeZone.getCurrentTimezoneDateUTC(that, '-end');
      var date_current_uct = TimeZone.getCurrentTimezoneDateUTC(that, '');

      var new_start = $.format.date(date_current_uct, "dd-MM-yyyy HH:mm:ss");
      var new_end = $.format.date(date_current_uct_end, "dd-MM-yyyy HH:mm:ss");
      $(that).find('._start').html(new_start);          
      $(that).find('._end').html(new_end);       
      var text = $(that).find('.calendar').html();  
      $(that).find('.addthisevent2').removeClass('addthisevent2').addClass('addthisevent');        
    },
    getRegisterForm: function(that, date_current){
      var date_current_end = TimeZone.getCurrentTimezoneDate(that, '-end');          
      var text = "<b>Date and Time</b> <br>";
      text += $.format.date(date_current, "E, MMM d, yyyy hh:mm a");
      text += " - ";
      text += $.format.date(date_current_end, "h:mm a");
      text += " UTC" + (offset_timezone / 60).toString();
      $(that).find('.date').html(text);
      return "";      
    },
    getStartIn: function(date_current){
      var text = "";
      var diff_min = TimeZone.roundToMin((date_current - new Date()) / 1000 / 60),
          diff_hours = TimeZone.roundToMin(diff_min / 60),
          diff_day = TimeZone.roundToMin(diff_min / 60 / 24),
          diff_month = TimeZone.roundToMin(diff_min / 60 / 24 / 30);

      diff_min -= 60 * diff_hours;
      diff_hours -= 24 * diff_day;
      diff_day -= 30 * diff_month;

      var text_month = diff_month > 1 ? " MONTHS" : " MONTH",
          text_day = diff_month > 1 ? " DAYS" : " DAY",
          text_hours = diff_month > 1 ? " HRS" : " HR",
          text_minutes = diff_month > 1 ? " MINS" : " MIN";

      if (diff_month > 0) {              
        text = diff_month + text_month + ", " + diff_day + text_day;
      } else {
        text = diff_day + text_day + ", " + diff_hours + text_hours + ", " + diff_min + text_minutes;
      } 
      return text;
    },
    changeDatesTimezone: function() {
      $(".change_timezone_text").each(function(){
        var post_timezone_type = $(this).attr('data-timezone-type');
        var date_current = TimeZone.getCurrentTimezoneDate(this, '');
        var text = TimeZone.getCorrectText(this, date_current, post_timezone_type);
        if (text != "") {
          $(this).html(text);
        }
        $(this).show();
      });
    }, 
    roundToMin: function(num) {
      var ret = Math.round(num);
      if (ret > num) {
        ret--;
      }
      return ret;
    }
  }
  $doc.ready(function() {
    TimeZone.init();
  });

})(jQuery, this);          

