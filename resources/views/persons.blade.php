            <table>
                <thead>
                    <tr>
                        <th>
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th style="padding-left: 25px;">&nbsp;&nbsp;&nbsp;&nbsp;Last Name</th>
                        <th>&nbsp;&nbsp;&nbsp;&nbsp;First Name</th>
                        <th>&nbsp;&nbsp;&nbsp;Mid Int.</th>
                        <th>&nbsp;&nbsp;Gender</th>
                        <th>&nbsp;Barangay</th>
                    </tr>
                </thead>
                <tbody class="content">
                    @foreach($data as $row)
                    <tr>
                        <td style="width: 40px;">
                           <input class="citizenCheckbox" name="citizen_checkbox[]" type="checkbox" value="{{ $row['id'] }}" id="p{{ $row['id'] }}">
                        </td>
                        <td>{{ $row['last_name'] }}</td>
                        <td>{{ $row['first_name'] }}</td>
                        <td>{{ $row['middle_initial'] }}</td>
                        <td>{{ $row['gender'] }}</td>
                        <td style="text-align: left;">{{ $row['barangay'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <script>
                $(document).on('change','.citizenCheckbox', function(){
                    var checkboxValues = {};
                    if($.cookie('checkboxValues1') != "")
                        checkboxValues = $.cookie('checkboxValues1');
                    var personValues = [];
                    if($.cookie('personValues') != "")
                        personValues = $.cookie('personValues');

                    $(".citizenCheckbox").each(function(){

                        checkboxValues[this.id] = this.checked;
                        if(this.checked){
                            personValues.push($(this).val());
                        }
                        else{
                            var index = personValues.indexOf($(this).val());
                            if (index > -1) {
                               personValues.splice(index, 1);
                            }
                        }
                    });

                    personValues = personValues.filter(function(item, index){
                        return personValues.indexOf(item) >= index;
                    });

                    $.cookie('checkboxValues1', checkboxValues, { expires: 7, path: '/' })
                    $.cookie('personValues', personValues, { expires: 7, path: '/' })
                  });

                function repopulateCheckboxes(){
                    var checkboxValues = $.cookie('checkboxValues1');
                    if(checkboxValues){
                      Object.keys(checkboxValues).forEach(function(element) {
                        var checked = checkboxValues[element];
                        $("#" + element).prop('checked', checked);
                      });
                    }
                }

                repopulateCheckboxes();
            </script>
