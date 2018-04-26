jQuery(document).ready(function() {

    jQuery("#generate").click(function(event) {
        postGraph();
    });
    
    jQuery("#graph_type").change(function(){
        //edit options for data via request to php that does file i/o
        var graphType = jQuery("#graph_type").val();
        jQuery(".variable").hide();
        jQuery(".categorical_var").hide();
        jQuery(".numerical_var").hide();
        if(graphType == "bar_chart"){
            jQuery("#x-axis").show();
            jQuery("#x-axis .categorical_var").show();
        }else if(graphType == "histogram"){
            jQuery("#x-axis").show();
            jQuery("#x-axis .numerical_var").show();
        }else if(graphType == "stacked_bar_chart"){
            jQuery("#x-axis").show();
            jQuery("#x-axis .categorical_var").show();
            jQuery("#y-axis").show();
            jQuery("#y-axis .categorical_var").show();
        }
    });


    // function updateDataChoices(){
    //     jQuery.ajax({
    //         type: "POST",
    //         url: "src/readColumns.php", //TODO
    //         data: {"graph_type": jQuery("#graph_type").val()},
    //         success: function(data){
    //             jQuery("#data_inputs").html(data);
    //         }
    //     });
    // }

    function postGraph(){
        //Might be possible to throw title, height, width and email into one array then pass that array into the request
        //very similar with the data inputs
        var inputs = document.getElementById("data_inputs").getElementsByTagName("select");
        var dataInput = [];
        for(i = 0 ; i < inputs.length; ++i){
            if(inputs[i].style['display'] != "none"){
                dataInput.push(inputs[i].value);
            }
        }
        console.log(JSON.stringify(dataInput));
        console.log(jQuery("#graph_type").val());
        console.log(jQuery("#title").val());
        console.log(WPC_Ajax.ajaxurl);
        //checking for duplicates in dataInputs
        let set = new Set(dataInput);
        if(set.size == dataInput.length){
            jQuery.ajax({
                type: "POST",
                url: WPC_Ajax.ajaxurl,
                data: {action: "wpc_post_graph",
                    graph_type: jQuery("#graph_type").val(),
                    gTitle : jQuery("#title").val(),
                    fontSize : jQuery("#fontSize").val(),
                    height : jQuery("#height").val(),
                    width : jQuery("#width").val(),
                    email : jQuery("#email").val(),
                    data: JSON.stringify(dataInput),
                },
                success: function(data){
                    var postInfo = JSON.parse(data);
                    console.log(postInfo);
                    jQuery("#hash").text("Graph with hash: " + postInfo[0]);
                    jQuery("#permalink").html("<a href='"+JSON.stringify(postInfo[1])+"'>"+JSON.stringify(postInfo[1])+"</a>");
                }
            });
        }else{
            jQuery("#hash").text("You can't have two of the same variables");
        }
    }
  }
);
