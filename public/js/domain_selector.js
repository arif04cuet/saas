var Domain_Selector={
    fldName: "",
	callback: null,
    get_subdomains_by_cat: function (select){

        var dtid = $(select).val();
		if(dtid!==''){
			var url = "/npfadmin/domains/getdomainids?ln=bn&dtid="+dtid;
			Domain_Selector.get_subdomains(select,url);
		}else{
			Domain_Selector.removeNextToAll(select);
		}		
    },
    removeNextToAll: function (select){
		$(select).parent().nextAll('div.div-subdomain').remove();
    },
    get_subdomains_by_dn: function (select){

        var did = $(select).val();
        var url = "/npfadmin/domains/getdomainids?ln=bn&did="+did;
        Domain_Selector.get_subdomains(select,url);
    },
    build_subdomains_list: function(select, data){
        var name = $(select).attr('name') + "_";
        var $div = $("<div>").attr('class','div-subdomain');
        var $a = $("<a>").html('select').attr('href','javascript:;').attr('class','btn btn-mini')
            .click(function(){
				if(Domain_Selector.callback){
					Domain_Selector.callback(this);
				}
                if(Domain_Selector.fldName!=""){
                    var v = $(this).prev().val();
                    //window.location = "http://"+v;
                    $('#'+Domain_Selector.fldName).val(v);
//                console.debug(v);
                    var v = $(this).prev().children(':selected').text() ;
//                console.debug(v);
                    $('#'+Domain_Selector.fldName+"_txt").val(v);
                    $('#Modal-Domain-Selector').modal('hide');
                }
                return false;
            });
		
        var $select = $("<select>").attr('name',name)
            .change(function() {
                Domain_Selector.get_subdomains_by_dn(this);
            }).mouseup(function(e){
				e.preventDefault();
			}).focus(function() {
				setTimeout(function() {$select.select();}, 0);
			});
        $.each(data, function() {
            var o = $("<option>").html(this.name).attr('value', this.did);
            o.appendTo($select);
        });

        Domain_Selector.removeNextToAll(select);

        $select.appendTo($div);
        $a.appendTo($div);
        $(select).parent().after($div);
    },
    get_subdomains: function (select,url)
    {
        $.post(url, function(data) {
        })
            .success(function(data) {
                if(data.length>0)
                {
                    Domain_Selector.build_subdomains_list(select, data);
                }
            })
            .error(function() {
            })
            .complete(function() {
            });
    }

};
