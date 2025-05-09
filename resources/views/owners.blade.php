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
                           <input class="ownerCheckbox" name="citizen_checkbox[]" type="checkbox" value="{{ $row['id'] }}" id="p{{ $row['id'] }}">
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
                $(document).ready(function(){
                    $('.ownerCheckbox').click(function() {
                        $('.ownerCheckbox').not(this).prop('checked', false);
                    });
                });

                $(document).on('change','.ownerCheckbox', function(){
                    var checkboxValues = {};
                    var ownerValue = "";

                    $(".ownerCheckbox").each(function(){
                      checkboxValues[this.id] = this.checked;
                    });

                    $(".ownerCheckbox").each(function(){
                        if(this.checked){
                            ownerValue = $(this).val();
                        }
                    });

                    $.cookie('checkboxValues3', checkboxValues, { expires: 7, path: '/' })
                    $.cookie('ownerValue', ownerValue, { expires: 7, path: '/' })
                  });

                function repopulateCheckboxes(){
                    var checkboxValues = $.cookie('checkboxValues3');
                    if(checkboxValues){
                      Object.keys(checkboxValues).forEach(function(element) {
                        var checked = checkboxValues[element];
                        $("#" + element).prop('checked', checked);
                      });
                    }
                }

                repopulateCheckboxes();
            </script>
