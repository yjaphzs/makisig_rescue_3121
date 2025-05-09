            <table>
                <thead>
                    <tr>
                        <th>
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th style="padding-left: 25px;">&nbsp;&nbsp;&nbsp;&nbsp;Last Name</th>
                        <th>&nbsp;&nbsp;&nbsp;&nbsp;First Name</th>
                        <th>&nbsp;Contact</th>
                    </tr>
                </thead>
                <tbody class="content">
                    @foreach($data as $row)
                    <tr>
                        <td style="width: 40px;">
                           <input class="responderCheckbox" name="responderCheckbox[]" type="checkbox" value="{{ $row['id'] }}" id="r{{ $row['id'] }}">
                        </td>
                        <td>{{ $row['last_name'] }}</td>
                        <td>{{ $row['first_name'] }}</td>
                        <td style="text-align: left;">{{ $row['contact'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <script>
                $(document).on('change','.responderCheckbox', function(){
                    var checkboxValues = {};
                    if($.cookie('checkboxValues2') != "")
                        checkboxValues = $.cookie('checkboxValues2');
                    var responderValues = [];
                    if($.cookie('responderValues') != "")
                        responderValues = $.cookie('responderValues');


                    $(".responderCheckbox").each(function(){
                        checkboxValues[this.id] = this.checked;
                        if(this.checked){
                            responderValues.push($(this).val());
                        }
                        else{
                            var index = responderValues.indexOf($(this).val());
                            if (index > -1) {
                               responderValues.splice(index, 1);
                            }
                        }
                    });

                    responderValues = responderValues.filter(function(item, index){
                        return responderValues.indexOf(item) >= index;
                    });

                    $.cookie('checkboxValues2', checkboxValues, { expires: 7, path: '/' })
                    $.cookie('responderValues', responderValues, { expires: 7, path: '/' })

                  });

                function repopulateCheckboxesResponders(){
                    var checkboxValues = $.cookie('checkboxValues2');
                    if(checkboxValues){
                      Object.keys(checkboxValues).forEach(function(element) {
                        var checked = checkboxValues[element];
                        $("#" + element).prop('checked', checked);
                      });
                    }
                }

                repopulateCheckboxesResponders();
            </script>
