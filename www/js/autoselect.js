$(document).ready(function()
{
	(function( $ ) 
	{
		$.widget( "ui.combobox", 
		{
			_create: function() 
			{
                var input,
                    that = this,
                    select = this.element.hide()  
                    selected = select.children( ":selected" ),
                    value = selected.val() ? selected.text() : "",
                    wrapper = this.wrapper = $( "<span>" ).addClass( "ui-combobox" ).insertAfter( select );
                function removeIfInvalid(element) 
                {
                	var value = $( element ).val(),
                    matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( value ) + "$", "i" ),
                    valid = false;
					select.children( "option" ).each(function() 
					{
						if ( $( this ).text().match( matcher ) ) 
						{
                            this.selected = valid = true;
                            return false;
                        }
                    });
                    if ( !valid ) 
                    {
                    	// remove invalid value, as it didn't match anything
                        $( element ).val( "" ).attr( "title", value + " didn't match any item" ).tooltip( "open" );
                        select.val( "" );
                        setTimeout(function() 
                        {
                            input.tooltip( "close" ).attr( "title", "" );
                        }, 2500 );
                        input.data( "autocomplete" ).term = "";
                        return false;
                    }
                }
                input = $( "<input>" ).appendTo( wrapper ).val( value ).attr( "title", "" ).attr( "name", "emidi" ).addClass( "ui-state-default ui-combobox-input searchbox" )
                		.autocomplete(
                		{
                			delay: 0,
                			minLength: 0,
                			source: function( request, response ) 
                			{
                				var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                				response( select.children( "option" ).map(function() 
                				{
                					var text = $( this ).text();
                					if ( this.value && ( !request.term || matcher.test(text) ) )
                						return {
                                        	label: text.replace(
                                        			new RegExp(
                                        				"(?![^&;]+;)(?!<[^<>]*)(" +
                                        				$.ui.autocomplete.escapeRegex(request.term) +
                                        				")(?![^<>]*>)(?![^&;]+;)", "gi"
                                        			), "<strong>$1</strong>" ),
                                        	value: text,
                                        	option: this
                                    		};
                				}) 
                			);
                        },
                        select: function( event, ui ) 
                        {
                            ui.item.option.selected = true;
                            that._trigger( "selected", event, 
                            {
                                item: ui.item.option
                            });
							$("select[name='emid'] option").removeAttr('selected');
							$("select[name='emid'] option").each(function()
							{
								if($(this).attr("value") == ui.item.option.value)
								{
									$(this).attr("selected","selected");
								}
							}); 
							$("select[name='emid']").trigger("change");
							setInterval(function()
							{ 
								if($("input[name='emidi']").length==0)
									$( "select[name='emid']" ).combobox();
							},10);
                        },
                        change: function( event, ui ) 
                        {
                            if ( !ui.item )
                                return removeIfInvalid( this );
                        }
                    })
                    .addClass( "ui-widget ui-widget-content ui-corner-left" );
 
                	input.data( "autocomplete" )._renderItem = function( ul, item ) 
                	{
                		return $( "<li>" ).data( "item.autocomplete", item ).append( "<a>" + item.label + "</a>" ).appendTo( ul );
                	};
            },
            destroy: function() 
            {
                this.wrapper.remove();
                this.element.show();
                $.Widget.prototype.destroy.call( this );
            }
        });
    })
    ( jQuery );
  	
	setInterval(function()
	{ 
		if($("input[name='emidi']").length==0)
			$( "select[name='emid']" ).combobox();
	},10);
    $( "select[name='emid']" ).combobox();
	$("input[name='nperiod']").live("click",function()
	{
		$(".ndays_wrapper").toggle()
	})
});