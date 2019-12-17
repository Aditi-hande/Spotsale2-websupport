/* Get data from the database and then Draw the Table */
$(document).ready(function () {

    var dataTable = GetDataRefresh();
    
} );

$(document).ready(function(){
    $("#insertbtn").click(function(){

        var x = document.forms["insertForm"]["cat_id"].value;
        var y = document.forms["insertForm"]["item_id"].value;
        var z = document.forms["insertForm"]["item_name"].value;
  
        if (x == "") {
            alert("cat_id must be filled out");
            return false;
        }
        if (y == "") {
            alert("item_id must be filled out");
            return false;
        }
        if (z == "") {
            alert("item_name must be filled out");
            return false;
        }

        $.post("../api/item/insert.php",
            {
                    'cat_id':document.forms["insertForm"]["cat_id"].value,
                    'item_id':document.forms["insertForm"]["item_id"].value,
                    'item_name':document.forms["insertForm"]["item_name"].value,
                    'qty':document.forms["insertForm"]["qty"].value,
                    'cost':document.forms["insertForm"]["cost"].value
            },
            function (json) {
                //alert(JSON.stringify(json));
                //var dataTable = GetDataRefresh();
                if(json.result == true) {
                    alert("Inserted");
                    window.location.reload(true);
                }
                else
                    alert("Error while inserting");
            }
        );
    });  
});

$(document).ready(function(){
    $("#updatebtn").click(function(){

        var x = document.forms["updateForm"]["cat_id"].value;
        var y = document.forms["updateForm"]["item_id"].value;
  
        if (x == "") {
            alert("cat_id must be filled out");
            return false;
        }
        if (y == "") {
            alert("item_id must be filled out");
            return false;
        }

        $.post("../api/item/update.php",
            {
                    'cat_id':document.forms["updateForm"]["cat_id"].value,
                    'item_id':document.forms["updateForm"]["item_id"].value,
                    'item_name':document.forms["updateForm"]["item_name"].value,
                    'qty':document.forms["updateForm"]["qty"].value,
                    'cost':document.forms["updateForm"]["cost"].value
            },
            function (json) {
                alert(JSON.stringify(json));
                window.location.reload(true);
                //var dataTable = GetDataRefresh();
                /*if(json.result == true)
                    alert("Inserted");
                else
                    alert("Error while inserting");*/
            }
        );
    });  
});

$(document).ready(function(){
    $("#deletebtn").click(function(){

        var x = document.forms["deleteForm"]["cat_id"].value;
        var y = document.forms["deleteForm"]["item_id"].value;
  
        if (x == "") {
            alert("cat_id must be filled out");
            return false;
        }
        if (y == "") {
            alert("item_id must be filled out");
            return false;
        }

        $.post("../api/item/delete.php",
            {
                    'cat_id':document.forms["deleteForm"]["cat_id"].value,
                    'item_id':document.forms["deleteForm"]["item_id"].value,
            },
            function (json) {
                alert(JSON.stringify(json));
                window.location.reload(true);
                //var dataTable = GetDataRefresh();
                /*if(json.result == true)
                    alert("Inserted");
                else
                    alert("Error while inserting");*/
            }
        );
    });  
});

function GetDataRefresh() {

    $.post("../api/item/read.php",{'func':1},
        function (json) {
            var tr=[];
            var result = json.records;
            console.log(json.records);
            for (var i = 0; i < result.length; i++) {
                tr.push('<tr>');
                tr.push("<td>" + result[i].cat_id + "</td>");
                tr.push("<td>" + result[i].item_id + "</td>");
                tr.push("<td>" + result[i].item_name + "</td>");
                tr.push("<td>" + result[i].qty + "</td>");
                tr.push("<td>" + result[i].cost + "</td>");
                tr.push("<td>" + "xxx" + "</td>");
                tr.push("<td>" + "xxx" + "</td>");
                tr.push('</tr>');
            }
            $('#myTable').append($(tr.join('')));
            var table = DrawTable();
        }
    );
}

function DrawTable() {
 // Setup - add a text input to each footer cell
    $('#myTable tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );

    // DataTable
    var table = $('#myTable').DataTable();

    $('#min, #max').keyup( function() {
        table.draw();
    } );

    // Apply the search
    table.columns().every( function () {
        var col = this;
        $( 'input', this.footer() ).on( 'keyup change clear', function () {
            if ( col.search() !== this.value ) {
                col
                    .search( this.value )
                    .draw();
            }
        } );
    } );
}


/* Custom filtering function which will search data in column four between two values */
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = parseInt( $('#min').val(), 10 );
        var max = parseInt( $('#max').val(), 10 );
        var cost = parseFloat( data[4] ) || 0; // use data for the cost column
 
        if ( ( isNaN( min ) && isNaN( max ) ) ||
             ( isNaN( min ) && cost <= max ) ||
             ( min <= cost  && isNaN( max ) ) ||
             ( min <= cost  && cost <= max ) )
        {
            return true;
        }
        return false;
    }
);