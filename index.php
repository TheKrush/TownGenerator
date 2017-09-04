<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  </head>
  <body>
    <form action="generated.php" id="form" method="post">
    <input name="name" id="townName" size="35">
    <select id="size" name='size'>
      <option id="Thorp">Thorp</option>
      <option id="Hamlet">Hamlet</option>
      <option id="Village">Village</option>
      <option id="Small Town">Small Town</option>
      <option id="Large Town">Large Town</option>
      <option id="Small City">Small City</option>
      <option id="Large City">Large City</option>
      <option id="Metropolis">Metropolis</option>
    </select>
    <br><br>
    <select id="community">
      <option id="custom">Custom community</option>
      <option id="isolated">Isolated community</option>
      <option id="mixed">Mixed community</option>
      <option id="integrated">Integrated community</option>
    </select>
    <button type="button" class="randompopulation">Random</button>
    <br><br>
    <div><strong id="totals">0%</strong></div>
    <div id="sliders">
      <div>
        <div class="populationslider" id="dwarf" /></div>
        <div class="container">
          <input id="dwarfvalue" name="values[dwarf]" class='values' value="<?php if(isset($townInfo['values']['dwarf'])){echo $townInfo['values']['dwarf']; }else{ echo 0;} ?>"> % of dwarves
          <span class="buttons">
          <button type="button" class="button upbutton">▲</button>
          <button type="button" class="button downbutton">▼</button>
          </span>
        </div>
      </div>
      <div>
        <div class="populationslider" id="dragonborn" /></div>
        <div class="container">
          <input id="dragonbornvalue" name="values[dragonborn]" class='values' value="0"> % of dragonborn
          <span class="buttons">
          <button type="button" class="button upbutton">▲</button>
          <button type="button" class="button downbutton">▼</button>
          </span>
        </div>
      </div>
      <div>
        <div class="populationslider" id="elf" /></div>
        <div class="container">
          <input id="elfvalue" name="values[elf]" class='values' value="0"> % of elves
          <span class="buttons">
          <button type="button" class="button upbutton">▲</button>
          <button type="button" class="button downbutton">▼</button>
          </span>
        </div>
      </div>
      <div>
        <div class="populationslider" id="gnome" /></div>
        <div class="container">
          <input id="gnomevalue" name="values[gnome]" class='values' value="0"> % of gnomes
          <span class="buttons">
          <button type="button" class="button upbutton">▲</button>
          <button type="button" class="button downbutton">▼</button>
          </span>
        </div>
      </div>
      <div>
        <div class="populationslider" id="halfelf" /></div>
        <div class="container">
          <input id="halfelfvalue" name="values[halfelf]" class='values' value="0"> % of half-elves
          <span class="buttons">
          <button type="button" class="button upbutton">▲</button>
          <button type="button" class="button downbutton">▼</button>
          </span>
        </div>
      </div>
      <div>
        <div class="populationslider" id="halfling" /></div>
        <div class="container">
          <input id="halflingvalue" name="values[halfling]" class='values' value="0"> % of halflings
          <span class="buttons">
          <button type="button" class="button upbutton">▲</button>
          <button type="button" class="button downbutton">▼</button>
          </span>
        </div>
      </div>
      <div>
        <div class="populationslider" id="halforc" /></div>
        <div class="container">
          <input id="halforcvalue" name="values[halforc]" class='values' value="0"> % of half-orcs
          <span class="buttons">
          <button type="button" class="button upbutton">▲</button>
          <button type="button" class="button downbutton">▼</button>
          </span>
        </div>
      </div>
      <div>
        <div class="populationslider" id="human" /></div>
        <div class="container">
          <input id="humanvalue" name="values[human]" class='values' value="0"> % of humans
          <span class="buttons">
          <button type="button" class="button upbutton">▲</button>
          <button type="button" class="button downbutton">▼</button>
          </span>
        </div>
      </div>
      <hr>
      <br>
      <div>
        <div class="childslider" id="child" /></div>
        <div class="container">
          <input id="childvalue" name="children" class='values' value="0"> % of children
        </div>
      </div>
    </div>
    <button type="submit">Submit</button>
    <script>
      var altval;
      var textblock;
      var chktot = 100;
      var scrore = 101;
      var alltot = 0;
      var sliders = $(".populationslider");
      var sliderVals = 0;
      var townName = $("#townName");
      var children = $("#childvalue");

      $( ".childslider" ).slider({
        animate: false,
        step: 1,
        range: "max",
        min: 0,
        max: 100,
        slide: function( event, ui ){
          textblock = "#"+$(this).attr("id")+"value";
          var thisVal = parseInt($(this).slider("option", "value"));
          $(textblock).val($(this).slider("option", "value"));
        },

        change: function( event, ui ){
          textblock = "#"+$(this).attr("id")+"value";
          var thisVal = parseInt($(this).slider("option", "value"));
          $(textblock).val($(this).slider("option", "value"));
        }
      });

      $( ".populationslider" ).slider({
        animate: false,
        step: 1,
        range: "max",
        min: 0,
        max: 100,

        slide: function( event, ui ){
          textblock = "#"+$(this).attr("id")+"value";
          var thisVal = parseInt($(this).slider("option", "value"));
          sliderVals = 0;
          sliders.each(function() {
            sliderVals += parseInt($(this).slider("option", "value"));
          });
          alltot = sliderVals;
          if (alltot > chktot) {
            altval = chktot + thisVal - alltot;
            $(this).slider("value", altval);
            $(textblock).val(altval);
            alltot = 100;
            return false;
          } else {
            $(textblock).val($(this).slider("option", "value"));
          }

          $("#totals").text(alltot + "%");
        },

        change: function( event, ui ){

          textblock = "#"+$(this).attr("id")+"value";

          var thisVal = parseInt($(this).slider("option", "value"));

          sliderVals = 0;
          sliders.each(function() {
            sliderVals += parseInt($(this).slider("option", "value"));
          });
          alltot = sliderVals;

          if (alltot > chktot) {
            altval = chktot + thisVal - alltot;
            $(this).slider("value", altval);
            $(textblock).val(altval);
            alltot = 100;
          } else {
            $(textblock).val($(this).slider("option", "value"));
          }

          $("#totals").text(alltot + "%");

        }
      });

      $(".values").change(function(){
        if (alltot > chktot) {
          altval = chktot + thisVal - alltot;
          $(this).parent().prev().slider("value", altval);
          alltot = 100;
        } else {
          $(this).parent().prev().slider("value", parseInt($(this).val()));
        }
      });

      var communities = {
        "custom": {
          "dwarf":     0,
          "dragonborn":   0,
          "elf":       0,
          "gnome":     0,
          "halfelf":     0,
          "halfling":   0,
          "halforc":     0,
          "human":     0
        },
        "isolated": {
          "dwarf":     1,
          "dragonborn":   1,
          "elf":       1,
          "gnome":     1,
          "halfelf":     1,
          "halfling":   2,
          "halforc":     1,
          "human":     95
        },
        "mixed": {
          "dwarf":     3,
          "dragonborn":   2,
          "elf":       5,
          "gnome":     2,
          "halfelf":     1,
          "halfling":   9,
          "halforc":     1,
          "human":     77
        },
        "integrated": {
          "dwarf":     10,
          "dragonborn":   7,
          "elf":       18,
          "gnome":     7,
          "halfelf":     5,
          "halfling":   20,
          "halforc":     3,
          "human":     30
        }
      };


      $('#community').change(function () {

        var type = $(this).find(":selected").attr("id");

        sliders.each(function() {
          $(this).slider("value", 0);
        });

        for(i = 0; i < Object.keys(communities[type]).length; i++) {
          var name = Object.keys(communities[type])[i];
          $("#"+name).slider("value", communities[type][name]);
        }
      });

      $('.button').click(function () {
        var buttontype = $(this).attr("class").split(" ")[1];
        var thisfield = $(this).parent().siblings().first().attr("id");
        console.log(thisfield);

        if(buttontype == "upbutton") {
          var switchfield = $(this).parent().parent().parent().prev().children().last().children().first().attr("id");
          if(!switchfield) {
            switchfield = $("#sliders").children().last().children().last().children().first().attr("id");
          }
        } else {
          var switchfield = $(this).parent().parent().parent().next().children().last().children().first().attr("id");

          if(!switchfield) {
            switchfield = $("#sliders").children().first().children().last().children().first().attr("id");
          }
        }

        console.log(switchfield);

        var switch1 = $("#"+thisfield).val();
        var switch2 = $("#"+switchfield).val();

        $("#"+thisfield).val(switch2);
        $("#"+switchfield).val(switch1);

        $("#"+thisfield).trigger("change");
        $("#"+switchfield).trigger("change");

      });

      $('.randompopulation').click(function(){

        $('#community').val("Custom community");

        var type = $('#community').find(":selected").attr("id");

        sliders.each(function() {
          $(this).slider("value", 0);
        });

        var previousMax = 101;

        var target = 100;
        var nums = [];
        var sum = 0;

        for(i = 7; i; i--)
        {
          var max = target - sum - i;
          var random = getRandomInt(1, max);
          sum = sum + random;
          nums.push(random);
        }

        nums.push(target - sum);

        nums = shuffle(nums);

        for(i = 0; i < Object.keys(communities[type]).length; i++) {
          var name = Object.keys(communities[type])[i];
          $("#"+name).slider("value", nums[i]);
        }
      });

      function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min)) + min;
      }
      function shuffle(array) {
        var currentIndex = array.length, temporaryValue, randomIndex;

        // While there remain elements to shuffle...
        while (0 !== currentIndex) {
          // Pick a remaining element...
          randomIndex = Math.floor(Math.random() * currentIndex);
          currentIndex -= 1;

          // And swap it with the current element.
          temporaryValue = array[currentIndex];
          array[currentIndex] = array[randomIndex];
          array[randomIndex] = temporaryValue;
        }

        return array;
      }


      $('form').on('submit', function() {

        if(townName.val() == "")
        {
          alert("The town needs a name!");
          return false;
        }

        if(alltot != 100) {
          alert("Total does not add up to 100%");
          return false;
        }

        return true;
      });

      $( document ).ready(function() {
        $('.populationslider').each(function(){
          textblock = "#"+$(this).attr("id")+"value";
          $(this).slider("value", $(textblock).val());
        });

        $(".childslider").slider("value", $("#childvalue").val());
      });
    </script>
  </body>
</html>