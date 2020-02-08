<tr>
    <td class="delete_row bg-red"><span>{{$row}}</span><input type="hidden" name="Ln_No" value="{{$row}}"></td>
    <td><input id="itm_no_input_{{$row}}" class="itm_no_input text-center" type="text"></td>
    <td>
        <select name="Itm_No" id="Itm_No_{{$row}}" class="Itm_No" >
            <option value="">{{trans('admin.select')}}</option>
            @foreach($items as $item)
                <option value="{{$item->Itm_No}}">{{$item->{'Itm_Nm'.ucfirst(session('lang'))} }}</option>
            @endforeach
        </select>
    </td>
    <td style="width: 9%">
        <select name="Unit_No" id="Unit_No_{{$row}}" class="Unit_No" >
            <option value="">{{trans('admin.select')}}</option>
{{--            @foreach($units as $unit)--}}
{{--                <option value="{{$unit->Unit_No}}">{{$unit->{'Unit_Nm'.ucfirst(session('lang'))} }}</option>--}}
{{--            @endforeach--}}
        </select>
    </td>
    <td><input type="text" name="Loc_No" id="Loc_No_{{$row}}" class="Loc_No"></td>
    <td><input type="number" min="1" name="Qty" id="Qty_{{$row}}" class="Qty"></td>
    <td><input type="number" min="1" name="Itm_Sal" id="Itm_Sal_{{$row}}" class="Itm_Sal"></td>
    <td><input type="text" id="item_tot_sal_{{$row}}" class="item_tot_sal"></td>
    <td><input type="text" name="Exp_Date" id="Exp_Date_{{$row}}" class="Exp_Date" style="padding: 0; border-radius: 0"></td>
    <td><input type="text" name="Batch_No" class="Batch_No" id="Batch_No_{{$row}}"></td>
    <td><input type="text" name="Disc1_Prct" id="Disc1_Prct_{{$row}}" class="Disc1_Prct"></td>
    <td><input type="text" name="Disc1_Val" id="Disc1_Val_{{$row}}" class="Disc1_Val"></td>
    <td><input type="text" name="Taxp_Extra" id="Taxp_Extra_{{$row}}" class="Taxp_Extra"></td>
    <td><input type="text" name="Taxv_Extra" id="Taxv_Extra_{{$row}}" class="Taxv_Extra"></td>
</tr>
