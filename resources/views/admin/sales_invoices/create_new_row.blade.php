<tr>
    <td class="delete_row bg-red"><span>{{$row}}</span><input type="hidden" name="Ln-No" value="`+count+`"></td>
    <td style="width: 11%"><input id="itm_no_input" class="itm_no_input" type="text"></td>
    <td style="width: 20%">
        <select name="Itm_No" id="Itm_No" class="Itm_No" >
            <option value="">{{trans('admin.select')}}</option>
            @foreach($items as $item)
                <option value="{{$item->Itm_No}}">{{$item->{'Itm_Nm'.ucfirst(session('lang'))} }}</option>
            @endforeach
        </select>
    </td>
    <td style="width: 9%">
        <select name="Unit_No" id="Unit_No" class="Unit_No" >
            <option value="">{{trans('admin.select')}}</option>
            @foreach($units as $unit)
                <option value="{{$unit->Unit_No}}">{{$unit->{'Unit_Nm'.ucfirst(session('lang'))} }}</option>
            @endforeach
        </select>
    </td>
    <td><input type="text" name="Loc_No" id="Loc_No" class="Loc_No"></td>
    <td><input type="number" min="1" name="Qty" id="Qty" class="Qty"></td>
    <td><input type="number" min="1" name="Itm_Sal" id="Itm_Sal" class="Itm_Sal"></td>
    <td><input type="text" id="item_tot_sal" class="item_tot_sal"></td>
    <td style="width: 11%;"><input type="text" name="Exp_Date" id="Exp_Date" class="Exp_Date" style="padding: 0; border-radius: 0"></td>
    <td><input type="text" name="Batch_No" class="Batch_No" id="Batch_No"></td>
    <td><input type="text" name="Disc1_Prct" id="Disc1_Prct" class="Disc1_Prct"></td>
    <td><input type="text" name="Disc1_Val" id="Disc1_Val" class="Disc1_Val"></td>
    <td><input type="text" name="Taxp_Extra" id="Taxp_Extra" class="Taxp_Extra"></td>
    <td><input type="text" name="Taxv_Extra" id="Taxv_Extra" class="Taxv_Extra"></td>
</tr>
