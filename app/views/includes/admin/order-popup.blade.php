<div id="popup" class="modal-box">
    <header>
        <a href="#" class="js-modal-close close">x</a>
        <h3>Update Order</h3>
    </header>
    <div class="modal-body">
        <p>Enter docket number</p>
        <input type="text" name="docket"/>

        <p>Choose courier</p>
        <select name="courier">
            @if(isset($couriers))

                @foreach($couriers as $courier)
                    <option value="{{$courier->id}}">{{$courier->name}}</option>
                @endforeach
            @endif
        </select>
        <br/><br/>
        <input type="button" name="btn-set-courier" value=" Update "/> &nbsp; <span id="message-courier" class="message"></span>
    </div>
    <footer>
        <a href="#" class="js-modal-close">Close</a>
    </footer>
</div>