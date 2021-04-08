<html>
<script type='text/javascript'>
    var data;
    $.ajax({
    dataType: "json",
    url: `file://${__dirname}/data.json`,
    data: data,
    success: function(data) {
         data = data;
      }
    });
    $(window).load(function(){
    $(data).each(function() {
        var output = "<a href='" + this.url + "'><div class='col-sm-12'><div class='panel panel-default'><div class='panel-body'><h4>" + this.title + "</h4><p>" + this.content + "</p></div></div></div></a>";
        $('#feed').append(output);
    });
    });
</script>
</html>
