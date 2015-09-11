@if(!$quoted)

    <form id="form-quotation">
<div class="list-container quotation-container">

    <h3 class="estimated">ESTIMATED INVOICE OF TREATMENT</h3><br/>

    <div>

        <div class="row-quot">
            <div class="column200 floatleft">Kind Attention</div>
            <div class="column250 floatleft"><input type="text" name="kind_attention"/></div>
            <div class="column50 floatleft">&nbsp;</div>
            <div class="column200 floatleft">Dated</div>
            <div class="column250 floatleft"><input type="date" name="dated" style="line-height:20px;"/></div>
            <div class="clear"></div>
        </div>

        <div class="row-quot">
            <div class="column200 floatleft">File Number</div>
            <div class="column250 floatleft"><input type="text" name="file_number"/></div>
            <div class="column50 floatleft">&nbsp;</div>
            <div class="column200 floatleft">Hospital Reference</div>
            <div class="column250 floatleft"><input type="text" name="hospital_reference"/></div>
            <div class="clear"></div>
        </div>

        <div class="row-quot">
            <div class="column200 floatleft">Patient Age</div>
            <div class="column250 floatleft"><input type="text" name="patient_age"/></div>
            <div class="column50 floatleft">&nbsp;</div>
            <div class="column200 floatleft">Sex</div>
            <div class="column250 floatleft">
                <label><input name="sex" type="radio" value="male" checked="checked"/> Male</label> &nbsp;
                <label><input name="sex" type="radio" value="female"/> Female</label>
            </div>
            <div class="clear"></div>
        </div>

        <div class="row-quot">
            <div class="column200 floatleft">Nationality</div>
            <div class="column250 floatleft"><input type="text" name="nationality"/></div>
            <div class="column50 floatleft">&nbsp;</div>
            <div class="column200 floatleft">Medical Speciality</div>
            <div class="column250 floatleft">
                <select name="medical_speciality">
                    <option value="0">Select Speciality</option>
                    <option value="cancer">Cancer</option>
                    <option value="cardiology">Cardiology</option>
                    <option value="aids">AIDS</option>
                    <option value="artherites">Arthritis</option>
                </select>
            </div>
            <div class="clear"></div>
        </div>

        <div class="row-quot">
            <div class="column200 floatleft">Referring Party</div>
            <div class="column250 floatleft"><input type="text" name="referring_party"/></div>
            <div class="column50 floatleft">&nbsp;</div>
            <div class="column200 floatleft">Treating Doctor</div>
            <div class="column250 floatleft"><input type="text" name="treating_doctor"/></div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="row-quot">
        <div class="column250 floatleft"><h3>Treatment Protocols &nbsp;-</h3></div>
        <div class="clear"></div>
    </div>
    <div class="txt800">
        <div class="column500 floatleft">
            <textarea name="treatment_protocols" style="resize: none; width: 100%; height: 100px;"></textarea>
        </div>
        <div class="clear"></div>
    </div>

    <div>

        <div class="row-quot">
            <div class="column250 floatleft"><h3>Treatment Protocols &nbsp;-</h3></div>
            <div class="clear"></div>
        </div>

        <div class="row-quot">
            <div class="column250 floatleft">&nbsp;</div>
            <div class="column250 floatleft">Prescribed</div>
            <div class="column250 floatleft">Cost(Twin Sharing)</div>
            <div class="column250 floatleft">Duration</div>
            <div class="clear"></div>
        </div>
        <div class="row-quot">
            <div class="column250 floatleft">Pre-Evaluation</div>
            <div class="column250 floatleft"><input type="text" name="pre_evaluation_prescribed"/></div>
            <div class="column250 floatleft"><input type="text" name="pre_evaluation_cost"/></div>
            <div class="column250 floatleft"><input type="text" name="pre_evolution_duration"/></div>
            <div class="clear"></div>
        </div>
        <div class="row-quot">
            <div class="column250 floatleft">Surgery I</div>
            <div class="column250 floatleft"><input type="text" name="surgery1_prescribed"/></div>
            <div class="column250 floatleft"><input type="text" name="surgery1_cost"/></div>
            <div class="column250 floatleft"><input type="text" name="surgery1_duration"/></div>
            <div class="clear"></div>
        </div>
        <div class="row-quot">
            <div class="column250 floatleft">Surgery II</div>
            <div class="column250 floatleft"><input type="text" name="surgery2_prescribed"/></div>
            <div class="column250 floatleft"><input type="text" name="surgery2_cost"/></div>
            <div class="column250 floatleft"><input type="text" name="surgery2_duration"/></div>
            <div class="clear"></div>
        </div>
        <div class="row-quot">
            <div class="column250 floatleft">Follow-up Post Discharge</div>
            <div class="column250 floatleft"><input type="text" name="followup_post_discharge_prescribed"/></div>
            <div class="column250 floatleft"><input type="text" name="followup_post_discharge_cost"/></div>
            <div class="column250 floatleft"><input type="text" name="followup_post_discharge_duration"/></div>
            <div class="clear"></div>
        </div>
        <div class="row-quot">
            <div class="column250 floatleft">Total</div>
            <div class="column250 floatleft"><input type="text" name="total_prescribed"/></div>
            <div class="column250 floatleft"><input type="text" name="total_cost"/></div>
            <div class="column250 floatleft"><input type="text" name="total_duration"/></div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>

    <h5>Remarks:-</h5>

    <div class="row-quot">
        <div class="floatleft column150">Clinical Success Rate -</div>
        <div class="floatleft column250"><input type="text" name="clinical_success_rate"/></div>
        <div class="clear"></div>
    </div>

    <div class="row-quot">
        <div class="floatleft column150">Length of Stay -</div>
        <div class="floatleft column250"><input type="text" name="length_of_stay"/></div>
        <div class="clear"></div>
    </div>

    <h5>Inclusions in the Hospital Package</h5>

    <div>
        <ul>
            <li>Transfers by AC Car to and from
                the Hospital to Airport on arrival/ departure</li>
            <li>The Stay includes the costs of
                the patient and one attendant with meals</li>
            <li>A comprehensive printed
                discharge Summary will be provided</li>
            <li>A personal dietician who will
                advise the patient throughout the stay</li>
            <li>Post discharge consultation by
                email</li>
            <li>The hospital accepts US Dollars
                and International Master or Visa Credit Card</li>
            <li>An Interpreter for patients who
                do not understand English</li>
        </ul>
    </div>
    <div class="col50"></div>

    <h5>Exclusions in the Hospital Package</h5>

    <div>
        <ul>
            <li>The attendant will need to
                check into a guest house once the patient goes into ICU at extra
                costs</li>
            <li class="font20 colorgreen col50">Treatment of any unrelated
                illness or procedures other than the one for which this estimate
                has been prepared</li>
            <li>Expenses for any additional
                hospital stay beyond the stipulated days as per the estimate</li>
            <li>Every Additional Implant that
                would be required apart from the ones included in the estimate</li>
            <li>Blood products more than 6
                units shall be charged extra</li>
            <li class="font20 colorgreen col50">All additional therapies or
                medical tests that would be required post the discharge which are
                not mentioned in the estimate</li>
            <li class="font20 colorgreen col50">All costs for the guest house
                for the patient and the attendant on discharge of the patient
                undergoing Follow up care</li>
        </ul>
    </div>

    <h5>IMPORTANT DECLARATIONS</h5>

    <div>
        <ul>
            <li class="font20 colorred col50">Please note that this plan of
                treatment is as per the attached reports which might vary in
                actual after patient's evaluation at the time of admission.</li>
            <li class="font20 colorred col50">More informed estimates can be
                provided once the patient has been thoroughly examined by the
                concerned physician and tests are done after admission at the
                hospital</li>
            <li class="font20 colorred col50">This is just an estimate and the
                final costs may vary if the doctor uses other consumables at the
                time of the procedure for better results and patient's safety</li>

        </ul>
    </div>

    <h5>Assistance Provided by</h5>

    <div class="txt800 paddingleft25">
        <ul>
            <li class="font20 col50">Online Consultations for your treatments
                prior to travel to India if required with the treating Doctor
                within the comforts of your home</li>
            <li>Comprehensive treatment estimates and
                quotes within the comforts of your home</li>
            <li>Visa invitation letters for the Patient
                and Attendants from the treating Hospitals</li>
            <li>Hospital bookings for treatment prior to
                arrival in India as per the requirements</li>
            <li class="font20 col50">Dedicated Case manager for you with daily
                Email / Whats App update to the family back home if required</li>
            <li>Mobile SIM card on arrival</li>
            <li>Guest House/ Hotel Bookings as required</li>
            <li>Currency Exchange as and when required</li>
            <li>Air Ticket Bookings if Required</li>
            <li>Taxis bookings as per requirements</li>
            <li>Shopping and tour Management for
                attendants</li>
            <li class="font20 col50">Follow Up Care on departure to home
                country via our local home country doctors trained by the treating
                doctors and regular clinics held by the treating doctors in the
                home country</li>
            <li class="font20 col50">Complete Online Management of your
                post-Surgery care by way of our Home Healthcare module</li>
            <li>Discounted Pharmacy products even post
                departure to home country</li>
            <li>Comprehensive support on your departure</li>
        </ul>
    </div>
    <div class="col50"></div>
    <div class="txt800 font20">Hope this vital information will help your
        patient in deciding positively to avail treatment in the above
        hospital. Should you require any additional information /
        clarification, we shall be pleased to send it through.
    </div>

    <h5>Disclaimer</h5>

    <div class="txt800">*This is just an estimate and the contents are as
        per the reports referred by the concerned party. The final outcome
        or costs would be dependent on the Physical evaluation of the
        patient by the concerned doctor at the referred hospital. The
        decision of the treatment at the referred hospital is completely on
        the patients discretion and choice. The decision has been made by
        the patient by carefully going through the website of the hospital
        and the doctors profile</div>
    </div>

</div>

    <br/>

    <input type="button" name="btn-save-quotation" value=" Save Quotation "/> &nbsp; <span class="message"></span>

</form>

@else

    <div class="list-container quotation-container">

        <h3 class="estimated">ESTIMATED INVOICE OF TREATMENT</h3><br/>

        <div>

            <div class="row-quot">
                <div class="column200 floatleft">Kind Attention</div>
                <div class="column250 floatleft">{{$quotation->kind_attention}}</div>
                <div class="column50 floatleft">&nbsp;</div>
                <div class="column200 floatleft">Dated</div>
                <div class="column250 floatleft">{{$quotation->dated}}</div>
                <div class="clear"></div>
            </div>

            <div class="row-quot">
                <div class="column200 floatleft">File Number</div>
                <div class="column250 floatleft">{{$quotation->file_number}}</div>
                <div class="column50 floatleft">&nbsp;</div>
                <div class="column200 floatleft">Hospital Reference</div>
                <div class="column250 floatleft">{{$quotation->hospital_reference}}</div>
                <div class="clear"></div>
            </div>

            <div class="row-quot">
                <div class="column200 floatleft">Patient Age</div>
                <div class="column250 floatleft">{{$quotation->patient_age}}</div>
                <div class="column50 floatleft">&nbsp;</div>
                <div class="column200 floatleft">Sex</div>
                <div class="column250 floatleft">
                    {{$quotation->sex}}
                </div>
                <div class="clear"></div>
                </div>

<div class="row-quot">
<div class="column200 floatleft">Nationality</div>
<div class="column250 floatleft">{{$quotation->nationality}}</div>
<div class="column50 floatleft">&nbsp;</div>
<div class="column200 floatleft">Medical Speciality</div>
<div class="column250 floatleft">
    {{$quotation->medical_speciality}}
</div>
<div class="clear"></div>
</div>

<div class="row-quot">
<div class="column200 floatleft">Referring Party</div>
<div class="column250 floatleft">{{$quotation->referring_party}}</div>
<div class="column50 floatleft">&nbsp;</div>
<div class="column200 floatleft">Treating Doctor</div>
<div class="column250 floatleft">{{$quotation->treating_doctor}}</div>
<div class="clear"></div>
</div>
</div>
<div class="row-quot">
<div class="column250 floatleft"><h3>Treatment Protocols &nbsp;-</h3></div>
<div class="clear"></div>
</div>
<div class="txt800">
<div class="column500 floatleft">
    {{$quotation->treatment_protocols}}
</div>
<div class="clear"></div>
</div>

        <div class="row-quot">
            <div class="column250 floatleft"><h3>Clinical Summary &nbsp;-</h3></div>
            <div class="clear"></div>
        </div>
        <div class="txt800">
            <div class="column500 floatleft">
                {{$quotation->clinical_summary}}
            </div>
            <div class="clear"></div>
        </div>


<div class="row-quot">
<div class="column250 floatleft"><h3>Treatment Protocols &nbsp;-</h3></div>
<div class="clear"></div>
</div>

<div class="row-quot">
<div class="column250 floatleft">&nbsp;</div>
<div class="column250 floatleft">Prescribed</div>
<div class="column250 floatleft">Cost(Twin Sharing)</div>
<div class="column250 floatleft">Duration</div>
<div class="clear"></div>
</div>
<div class="row-quot">
<div class="column250 floatleft">Pre-Evaluation</div>
<div class="column250 floatleft">{{$quotation->pre_evaluation_prescribed}}</div>
<div class="column250 floatleft">{{$quotation->pre_evaluation_cost}}</div>
<div class="column250 floatleft">{{$quotation->pre_evolution_duration}}</div>
<div class="clear"></div>
</div>
<div class="row-quot">
<div class="column250 floatleft">Surgery I</div>
<div class="column250 floatleft">{{$quotation->surgery1_prescribed}}</div>
<div class="column250 floatleft">{{$quotation->surgery1_cost}}</div>
<div class="column250 floatleft">{{$quotation->surgery1_duration}}</div>
<div class="clear"></div>
</div>
<div class="row-quot">
<div class="column250 floatleft">Surgery II</div>
<div class="column250 floatleft">{{$quotation->surgery2_prescribed}}</div>
<div class="column250 floatleft">{{$quotation->surgery2_cost}}</div>
<div class="column250 floatleft">{{$quotation->surgery2_duration}}</div>
<div class="clear"></div>
</div>
<div class="row-quot">
<div class="column250 floatleft">Follow-up Post Discharge</div>
<div class="column250 floatleft">{{$quotation->followup_post_discharge_prescribed}}</div>
<div class="column250 floatleft">{{$quotation->followup_post_discharge_cost}}</div>
<div class="column250 floatleft">{{$quotation->followup_post_discharge_duration}}</div>
<div class="clear"></div>
</div>
<div class="row-quot">
<div class="column250 floatleft">Total</div>
<div class="column250 floatleft">{{$quotation->total_prescribed}}</div>
<div class="column250 floatleft">{{$quotation->total_cost}}</div>
<div class="column250 floatleft">{{$quotation->total_duration}}</div>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>

<h5>Remarks:-</h5>

<div class="row-quot">
<div class="floatleft column150">Clinical Success Rate -</div>
<div class="floatleft column250">{{$quotation->clinical_success_rate}}</div>
<div class="clear"></div>
</div>

<div class="row-quot">
<div class="floatleft column150">Length of Stay -</div>
<div class="floatleft column250">{{$quotation->length_of_stay}}</div>
<div class="clear"></div>
</div>

<h5>Inclusions in the Hospital Package</h5>

<div>
<ul>
<li>Transfers by AC Car to and from
    the Hospital to Airport on arrival/ departure</li>
<li>The Stay includes the costs of
    the patient and one attendant with meals</li>
<li>A comprehensive printed
    discharge Summary will be provided</li>
<li>A personal dietician who will
    advise the patient throughout the stay</li>
<li>Post discharge consultation by
    email</li>
<li>The hospital accepts US Dollars
    and International Master or Visa Credit Card</li>
<li>An Interpreter for patients who
    do not understand English</li>
</ul>
</div>
<div class="col50"></div>

<h5>Exclusions in the Hospital Package</h5>

<div>
<ul>
<li>The attendant will need to
    check into a guest house once the patient goes into ICU at extra
    costs</li>
<li class="font20 colorgreen col50">Treatment of any unrelated
    illness or procedures other than the one for which this estimate
    has been prepared</li>
<li>Expenses for any additional
    hospital stay beyond the stipulated days as per the estimate</li>
<li>Every Additional Implant that
    would be required apart from the ones included in the estimate</li>
<li>Blood products more than 6
    units shall be charged extra</li>
<li class="font20 colorgreen col50">All additional therapies or
    medical tests that would be required post the discharge which are
    not mentioned in the estimate</li>
<li class="font20 colorgreen col50">All costs for the guest house
    for the patient and the attendant on discharge of the patient
    undergoing Follow up care</li>
</ul>
</div>

<h5>IMPORTANT DECLARATIONS</h5>

<div>
<ul>
<li class="font20 colorred col50">Please note that this plan of
    treatment is as per the attached reports which might vary in
    actual after patient's evaluation at the time of admission.</li>
<li class="font20 colorred col50">More informed estimates can be
    provided once the patient has been thoroughly examined by the
    concerned physician and tests are done after admission at the
    hospital</li>
<li class="font20 colorred col50">This is just an estimate and the
    final costs may vary if the doctor uses other consumables at the
    time of the procedure for better results and patient's safety</li>

</ul>
</div>

<h5>Assistance Provided by</h5>

<div class="txt800 paddingleft25">
<ul>
<li class="font20 col50">Online Consultations for your treatments
    prior to travel to India if required with the treating Doctor
    within the comforts of your home</li>
<li>Comprehensive treatment estimates and
    quotes within the comforts of your home</li>
<li>Visa invitation letters for the Patient
    and Attendants from the treating Hospitals</li>
<li>Hospital bookings for treatment prior to
    arrival in India as per the requirements</li>
<li class="font20 col50">Dedicated Case manager for you with daily
    Email / Whats App update to the family back home if required</li>
<li>Mobile SIM card on arrival</li>
<li>Guest House/ Hotel Bookings as required</li>
<li>Currency Exchange as and when required</li>
<li>Air Ticket Bookings if Required</li>
<li>Taxis bookings as per requirements</li>
<li>Shopping and tour Management for
    attendants</li>
<li class="font20 col50">Follow Up Care on departure to home
    country via our local home country doctors trained by the treating
    doctors and regular clinics held by the treating doctors in the
    home country</li>
<li class="font20 col50">Complete Online Management of your
    post-Surgery care by way of our Home Healthcare module</li>
<li>Discounted Pharmacy products even post
    departure to home country</li>
<li>Comprehensive support on your departure</li>
</ul>
</div>
<div class="col50"></div>
<div class="txt800 font20">Hope this vital information will help your
patient in deciding positively to avail treatment in the above
hospital. Should you require any additional information /
clarification, we shall be pleased to send it through.
</div>

<h5>Disclaimer</h5>

<div class="txt800">*This is just an estimate and the contents are as
per the reports referred by the concerned party. The final outcome
or costs would be dependent on the Physical evaluation of the
patient by the concerned doctor at the referred hospital. The
decision of the treatment at the referred hospital is completely on
the patients discretion and choice. The decision has been made by
the patient by carefully going through the website of the hospital
and the doctors profile</div>
</div>

</div>

@endif