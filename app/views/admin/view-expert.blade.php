<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Administration | View Expert</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.admin.common_css')

    {{HTML::style(asset("/public/css/AdminLTE.css"))}}
    {{HTML::style(asset("/public/css/admin-skins/_all-skins.min.css"))}}

    @include('includes.admin.common_js_top')
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-left: 0px !important;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Expert: {{$expert->first_name}} {{$expert->last_name}}
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class='tab-container'>
                <ul class='tabs'>
                    <li><a href='#tab-edit'>Edit</a></li>
                    <li><a href='#tab-memberships'>Memberships</a></li>
                    <li><a href='#tab-specialties'>Specialties</a></li>
                    <li><a href='#tab-services'>Services</a></li>
                    <li><a href='#tab-achievements'>Achievements</a></li>
                    <li><a href='#tab-social'>Social profiles</a></li>
                    <li><a href='#tab-qualification'>Qualification</a></li>
                    <li><a href='#tab-address'>Address</a></li>
                </ul>

                <div id='tab-edit'>
                    <div id='form-container'>
                        <form id='form-create-book' action="{{$root}}/update-admin-expert" method="post" target="ifr" enctype="multipart/form-data"
                              onsubmit="startUpdatingExpert()">
                            <div class='form-row'>
                                <div class='form-label'>First Name</div>
                                <div class='form-data'>
                                    <input type='text' name='first_name' value="{{$expert->first_name}}"/>
                                </div>
                                <div class='form-label'>Last Name</div>
                                <div class='form-data'>
                                    <input type='text' name='last_name' value="{{$expert->last_name}}"/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Password</div>
                                <div class='form-data'>
                                    <input type='text' name='password' value="{{$expert->password}}"/>
                                </div>
                                <div class='form-label'>Confirm Password</div>
                                <div class='form-data'>
                                    <input type='text' name='confirm_password' value="{{$expert->password}}"/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Email</div>
                                <div class='form-data'>
                                    <input type='text' name='email' value="{{$expert->email}}"/>
                                </div>
                                <div class='form-label'>Contact Number</div>
                                <div class='form-data'>
                                    <input type='text' name='contact_number' value="{{$expert->contact_number}}"/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Title</div>
                                <div class='form-data'>
                                    <input type='text' name='title' value="{{$expert->title}}"/>
                                </div>
                                <div class='form-label'>Gender</div>
                                <div class='form-data'>
                                    <select name='gender'>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Highest Qualification</div>
                                <div class='form-data'>
                                    <input type='text' name='highest_qualification' value="{{$expert->highest_qualification}}"/>
                                </div>
                                <div class='form-label'>Extension Number</div>
                                <div class='form-data'>
                                    <input type='text' name='extension_number' value="{{$expert->extension_number}}"/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>About</div>
                                <div class='form-data-full'>
                                    <textarea name="about" rows="5">{{$expert->about}}</textarea>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Experience</div>
                                <div class='form-data-full'>
                                    <textarea name="experience" rows="5">{{$expert->experience}}</textarea>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Image</div>
                                <div class='form-data-full'>
                                    <input type="file" name="image"/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Banner image</div>
                                <div class='form-data-full'>
                                    <input type="file" name="banner_image"/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>&nbsp;</div>
                                <div class='form-data-full'>
                                    <input type='submit' value="Update Expert" class='half'/> <span
                                            class='message'></span>
                                </div>
                                <div class='clear'></div>
                            </div>
                        </form>
                        <iframe id="ifr" name="ifr" style="visibility: hidden; width:1px; height:1px"></iframe>
                    </div>
                </div>

                <div id='tab-memberships'>

                    <form id='form-create-membership'>
                        <div class='form-row'>
                            <div class='form-label'>Name</div>
                            <div class='form-data'>
                                <input type='text' name='name'/>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>Details</div>
                            <div class='form-data'>
                                <textarea name='details' rows="4"></textarea>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>&nbsp;</div>
                            <div class='form-data'>
                                <input type='button' name='btn-create-membership' value="Create Membership" class="half"/><span
                                        class='message'></span>
                            </div>
                            <div class='clear'></div>
                        </div>
                    </form>

                    <div id='membership-list' class='list-container'></div>

                </div>

                <div id='tab-specialties'>

                    <form id='form-create-specialty'>
                        <div class='form-row'>
                            <div class='form-label'>Name</div>
                            <div class='form-data'>
                                <input type='text' name='name'/>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>Details</div>
                            <div class='form-data'>
                                <textarea name='details' rows="4"></textarea>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>&nbsp;</div>
                            <div class='form-data'>
                                <input type='button' name='btn-create-specialty' value="Create Specialty" class="half"/><span
                                        class='message'></span>
                            </div>
                            <div class='clear'></div>
                        </div>
                    </form>

                    <div id='specialty-list' class='list-container'></div>
                </div>

                <div id='tab-services'>

                    <form id='form-create-service'>
                        <div class='form-row'>
                            <div class='form-label'>Name</div>
                            <div class='form-data'>
                                <input type='text' name='name'/>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>Details</div>
                            <div class='form-data'>
                                <textarea name='details' rows="4"></textarea>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>&nbsp;</div>
                            <div class='form-data'>
                                <input type='button' name='btn-create-service' value="Create Service" class="half"/><span
                                        class='message'></span>
                            </div>
                            <div class='clear'></div>
                        </div>
                    </form>

                    <div id='service-list' class='list-container'></div>
                </div>

                <div id='tab-achievements'>

                    <form id='form-create-achievement'>
                        <div class='form-row'>
                            <div class='form-label'>Name</div>
                            <div class='form-data'>
                                <input type='text' name='name'/>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>Details</div>
                            <div class='form-data'>
                                <textarea name='details' rows="4"></textarea>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>&nbsp;</div>
                            <div class='form-data'>
                                <input type='button' name='btn-create-achievement' value="Create Achievement" class="half"/><span
                                        class='message'></span>
                            </div>
                            <div class='clear'></div>
                        </div>
                    </form>

                    <div id='achievement-list' class='list-container'></div>
                </div>

                <div id='tab-social'>

                    <form id='form-create-social'>
                        <div class='form-row'>
                            <div class='form-label'>Name</div>
                            <div class='form-data'>
                                <input type='text' name='name'/>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>URL</div>
                            <div class='form-data'>
                                <input type='text' name='url'/>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>&nbsp;</div>
                            <div class='form-data'>
                                <input type='button' name='btn-create-social' value="Create Social" class="half"/><span
                                        class='message'></span>
                            </div>
                            <div class='clear'></div>
                        </div>
                    </form>

                    <div id='social-list' class='list-container'></div>
                </div>

                <div id='tab-qualification'>

                    <form id='form-create-qualification'>
                        <div class='form-row'>
                            <div class='form-label'>Name</div>
                            <div class='form-data'>
                                <input type='text' name='name'/>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>Description</div>
                            <div class='form-data'>
                                <textarea name='description' rows="4"></textarea>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>&nbsp;</div>
                            <div class='form-data'>
                                <input type='button' name='btn-create-qualification' value="Create Qualification" class="half"/><span
                                        class='message'></span>
                            </div>
                            <div class='clear'></div>
                        </div>
                    </form>

                    <div id='qualification-list' class='list-container'></div>

                </div>

                <div id='tab-address'>

                    <form id='form-create-location'>
                        <div class='form-row'>
                            <div class='form-label'>State</div>
                            <div class='form-data'>
                                <select name="state">
                                    <option>Andaman and Nicobar Islands</option>
                                    <option>Andhra Pradesh</option>
                                    <option>Arunachal Pradesh</option>
                                    <option>Assam</option>
                                    <option>Bihar</option>
                                    <option>Chandigarh</option>
                                    <option>Chhattisgarh</option>
                                    <option>Dadar and Nagar Haveli</option>
                                    <option>Daman and Diu</option>
                                    <option>Delhi</option>
                                    <option>Goa</option>
                                    <option>Gujarat</option>
                                    <option>Haryana</option>
                                    <option>Himachal Pradesh</option>
                                    <option>Jammu and Kashmir</option>
                                    <option>Jharkhand</option>
                                    <option>Karnataka</option>
                                    <option>Kerala</option>
                                    <option>Lakshadeep</option>
                                    <option>Madya Pradesh</option>
                                    <option>Maharashtra</option>
                                    <option>Manipur</option>
                                    <option>Meghalaya</option>
                                    <option>Mizoram</option>
                                    <option>Nagaland</option>
                                    <option>Orissa</option>
                                    <option>Pondicherry</option>
                                    <option>Punjab</option>
                                    <option>Rajasthan</option>
                                    <option>Sikkim</option>
                                    <option>Tamil Nadu</option>
                                    <option>Tripura</option>
                                    <option>Uttaranchal</option>
                                    <option>Uttar Pradesh</option>
                                    <option>West Bengal</option>
                                </select>
                            </div>
                            <div class='form-label'>City</div>
                            <div class='form-data'>
                                <select name="city">
                                </select>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>Address</div>
                            <div class='form-data'>
                                <textarea name='address' rows="4"></textarea>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>Latitude</div>
                            <div class='form-data'>
                                <input type='text' name='latitude'/>
                            </div>
                            <div class='form-label'>Longitude</div>
                            <div class='form-data'>
                                <input type='text' name='longitude'/>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>&nbsp;</div>
                            <div class='form-data'>
                                <input type='button' name='btn-create-location' value="Create Location" class="half"/><span
                                        class='message'></span>
                            </div>
                            <div class='clear'></div>
                        </div>
                    </form>

                    <div id='location-list' class='list-container'></div>

                </div>
            </div>

        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

@include('includes/common_js_bottom')
{{HTML::script(asset("/public/js/site/admin/view-expert.js"))}}
<script>
    $("select[name='gender']").val("{{$expert->gender}}");
</script>
<span style="display: none" rel='{{$expert->id}}' id='expert_id'>&nbsp;</span>
</body>
</html>