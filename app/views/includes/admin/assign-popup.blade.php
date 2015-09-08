<div id="assign-popup">
    <form id="form-assign-request">
        <p style="padding-top: 10px;">Consultant</p>
        <select name="category_consultant">
            @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>

        <select name="consultant_id">
        </select>

        <p style="padding-top: 20px;">Expert</p>
        <select name="category_expert">
            @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>

        <select name="expert_id">
        </select>

        <hr/>

        <input type="button" name="btn-assign-request" value=" Assign "/> &nbsp; <span class="message message-assign"></span>
    </form>
</div>