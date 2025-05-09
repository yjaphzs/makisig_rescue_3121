            <table>
                <thead>
                    <tr>
                        <th>
                            <input id="bulk_checkbox" type="checkbox">
                        </th>
                        <th>
                            <button id="bulk_delete"><span class="fa fa-trash"></span></button>
                        </th>
                        <!--
                        <th></th>
                        -->
                        <th></th>
                        <th></th>
                        <th style="overflow-x: inherit;">
                            <button class="dropdown">
                                <span class="fa fa-filter"></span>
                                <span class="fa fa-angle-down"></span>
                                <div class="drawer" style="bottom: -65px;">
                                    <a href="" value="owner">Owner</a>
                                    <a href="" value="items">Items</a>
                                </div>
                            </button>
                        </th>
                    </tr>
                    <tr>
                        <th></th>
                        <!--
                        <th>ID</th>
                        -->
                        <th>Owner</th>
                        <th>Items</th>
                        <th>Remarks</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="content">
                    @foreach($data as $row)
                    <tr>
                        <td>
                           <input class="citizenCheckbox" name="citizen_checkbox[]" type="checkbox" value="{{ $row['id'] }}">
                        </td>
                        <?php
                            $name = "";
                            $id = $row['owner'];
                            foreach($data2 as $row2){
                                if($id == $row2['id']){
                                    $name .= $row2['first_name'].' '.$row2['last_name'];
                                }
                            }

                        ?>
                        <!--
                            <td>{{ $row['id'] }}</td>
                        -->
                        <td>{{ $name }}</td>
                        <td>{{ $row['items'] }}</td>
                        <td>{{ $row['remarks'] }}</td>
                        <td>
                            <!--
                            <button id="{{ $row['id'] }}" class="viewButton tooltip"><span class="fa fa-eye"></span><span class="tooltiptext">View</span></button>
                            -->
                            <button id="{{ $row['id'] }}" class="editButton tooltip"><span class="fa fa-edit"></span><span class="tooltiptext">Edit</span></button>
                            <button id="{{ $row['id'] }}" class="deleteButton tooltip"><span class="fa fa-trash-alt"></span><span class="tooltiptext">Delete</span></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        {{ $data->onEachSide(1)->links() }}
