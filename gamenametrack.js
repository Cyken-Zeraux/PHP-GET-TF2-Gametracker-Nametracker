//The MIT License (MIT)
//
//Copyright (c) 2014 Cyken Zeraux aka CZauX
//
//Permission is hereby granted, free of charge, to any person obtaining a copy
//of this software and associated documentation files (the "Software"), to deal
//in the Software without restriction, including without limitation the rights
//to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
//copies of the Software, and to permit persons to whom the Software is
//furnished to do so, subject to the following conditions:
//
//The above copyright notice and this permission notice shall be included in all
//copies or substantial portions of the Software.
//
//THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
//IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
//FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
//AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
//LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
//OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
//SOFTWARE.

$( document ).ready(function() {
  //Redone in PHP, keeping for reasons.
  //$( ".table_lst_spn" ).children().clone().appendTo( "#newbody" );

  var i = 0;
  //Gets player names and makes an array with them
  var namearray = [];
  $( '#newbody .table_lst_spn .c02' ).each(function() {
    i++;
    namearray[i] = $.trim($( this ).text());
  });
  i = 0;
  //lazy way of removing table headers
  namearray = $.grep(namearray,function(n){ return(n) });
  namearray.splice(0, 1);
  namearray.splice(-1, 1);
  console.log($.trim(namearray.toString()));
  
  var pointsarray = [];
  $( '#newbody .table_lst_spn .c04' ).each(function() {
    i++;
    pointsarray[i] = $.trim($( this ).text());
  });
  i = 0;
  pointsarray = $.grep(pointsarray,function(n){ return(n) });
  pointsarray.splice(0, 1);
  pointsarray.splice(-1, 1);
  console.log($.trim(pointsarray.toString()));

  var timearray = [];
  $( '#newbody .table_lst_spn .c05' ).each(function() {
    i++;
    timearray[i] = $.trim($( this ).text());
  });
  i = 0;
  timearray = $.grep(timearray,function(n){ return(n) });
  timearray.splice(0, 1);
  timearray.splice(-1, 1);
  console.log($.trim(timearray.toString()));
  
  //Uses the previously created arrays to create HTML elements using the array values.
  //These elements are then appended to the incrementing element ID.
  for (var i = 0; i < namearray.length; i++) {
    $('<div class="" id="stack-' + i + '" style="width:500px;">').appendTo('#javaleft');
    $('<input class="leftblock">').attr({
      type: "checkbox",
      //onclick: "dothemath(array(pointsarray[" + i + "], timearray[" + i + "]));",
      value: namearray[i]
    }).appendTo('#stack-' + i);

    $('<p class="rightblock">').html(
    namearray[i]
    ).appendTo('#stack-' + i);
  }
  
  //This is all the math
  var addpoints = 0;
  var addhours = 0;
  var addratio = 0;
  $(".leftblock").click(function() {
    //gets the number of the ID that we set before. This makes it so we don't have to loop through all the checkboxes.
    var idsplit = $(this).parent().attr('id').split("-");
    if ( $(this).prop("checked") == true) {
      addpoints += parseInt(pointsarray[idsplit[1]]);
      addhours += parseInt(timearray[idsplit[1]]);
    }
    if ( $(this).prop("checked") == false) {
      addpoints -= parseInt(pointsarray[idsplit[1]]);
      addhours -= parseInt(timearray[idsplit[1]]);
    }

    addratio = Number((addpoints / (addhours * 60)).toFixed(2));
    $( '#overpointspost' ).text(addpoints);
    $( '#overhourspost' ).text(addhours);
    $( '#overatiopost' ).text(addratio);
  });
 i = 0;
 
 
 
 document.getElementById("myCheck").click();
 
 
 
 
 
});