            <table>
                <thead>
                    <tr>
                        <th>
                            <!-- <input id="bulk_checkbox" type="checkbox"> -->
                        </th>
                        <th>
                            <!-- <button id="bulk_delete"><span class="fa fa-trash"></span></button> -->
                        </th>
                        <!--
                        <th></th>
                        -->
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th style="overflow-x: inherit;">
                            <button class="dropdown">
                                <span class="fa fa-filter"></span>
                                <span class="fa fa-angle-down"></span>
                                <div class="drawer" style="bottom: -150px;">
                                    <a href="" value="last_name">Last Name</a>
                                    <a href="" value="first_name">First Name</a>
                                    <a href="" value="middle_initial">Middle Int.</a>
                                    <a href="" value="gender">Gender</a>
                                    <a href="" value="barangay">Barangay</a>
                                </div>
                            </button>
                        </th>
                    </tr>
                    <tr>
                        <th></th>
                        <!--<th>ID</th>-->
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Mid Int.</th>
                        <th>Gender</th>
                        <th>Barangay</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="content">
                    @foreach($data as $row)
                    <tr>
                        <td>
                           <input class="citizenCheckbox" name="citizen_checkbox[]" type="checkbox" value="{{ $row['id'] }}">
                        </td>
                        <!--
                        <td>{{ $row['id'] }}</td>
                        -->
                        <td>{{ $row['last_name'] }}</td>
                        <td>{{ $row['first_name'] }}</td>
                        <td>{{ $row['middle_initial'] }}</td>
                        <td>{{ $row['gender'] }}</td>
                        <td>{{ $row['barangay'] }}</td>
                        <td>
                            <!--
                            <button id="{{ $row['id'] }}" class="viewButton"><span class="fa fa-eye"></span></button>
                            -->
                            <button id="{{ $row['id'] }}" class="editButton tooltip"><span class="fa fa-edit"></span><span class="tooltiptext">Edit</span></button>
                            <!--
                            <button id="{{ $row['id'] }}" class="deleteButton tooltip"><span class="fa fa-trash-alt"></span><span class="tooltiptext">Delete</span></button>
                            -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        {{ $data->onEachSide(1)->links() }}
