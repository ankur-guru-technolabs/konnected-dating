<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{route('/')}}">
            <img src="{{ asset('images/konnected-dating-red.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">Konnected Dating</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    @php

        function isActivePrefix($routeName,$className) {
            if (Str::startsWith(Route::getCurrentRoute()->getPrefix(), 'questions/') && $routeName == "questions") {
                return $className;
            }
            return trim(Route::getCurrentRoute()->getPrefix(), '/') == $routeName ? $className : '';
        }

        function isActive($routeName) {
            return Route::currentRouteName() == $routeName ? 'active' : '';
        }

    @endphp
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white  {{ (Route::currentRouteName() == 'dashboard') ? 'active bg-gradient-primary' : '' }}" href="{{route('dashboard')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#question_management_menu" class="nav-link text-white {{ isActivePrefix('questions','active') }}" aria-controls="question_management_menu" role="button" aria-expanded="{{ isActivePrefix('questions','true') }}">
                    <i class="material-icons-round opacity-10">quiz</i>
                    <span class="nav-link-text ms-2 ps-1">Question Handling</span>
                </a>
                <div class="collapse {{ isActivePrefix('questions','show') }}" id="question_management_menu">
                    <ul class="nav ">
                        <li class="nav-item {{isActive('questions.ages.list')}}">
                            <a class="nav-link text-white {{isActive('questions.ages.list')}}" href="{{route('questions.ages.list')}}">
                                <img class="menu-img-class" src="{{ asset('images/age.png') }}">
                                <span class="sidenav-normal  ms-2  ps-1">Age</span>
                            </a>
                        </li>
                        <li class="nav-item {{isActive('questions.bodytype.list')}}">
                            <a class="nav-link text-white {{isActive('questions.bodytype.list')}}" href="{{route('questions.bodytype.list')}}">
                                <img class="menu-img-class" src="{{ asset('images/body-type.png') }}">
                                <span class="sidenav-normal  ms-2  ps-1">Body Types</span>
                            </a>
                        </li>
                        <li class="nav-item {{isActive('questions.children.list')}}">
                            <a class="nav-link text-white {{isActive('questions.children.list')}}" href="{{route('questions.children.list')}}">
                                <img class="menu-img-class" src="{{ asset('images/children.png') }}">
                                <span class="sidenav-normal  ms-2  ps-1">Childrens</span>
                            </a>
                        </li>
                        <li class="nav-item {{isActive('questions.education.list')}}">
                            <a class="nav-link text-white {{isActive('questions.education.list')}}" href="{{route('questions.education.list')}}">
                                <img class="menu-img-class" src="{{ asset('images/education.png') }}">
                                <span class="sidenav-normal  ms-2  ps-1">Education</span>
                            </a>
                        </li>
                        <li class="nav-item {{isActive('questions.ethnicity.list')}}">
                            <a class="nav-link text-white {{isActive('questions.ethnicity.list')}}" href="{{route('questions.ethnicity.list')}}">
                                <img class="menu-img-class" src="{{ asset('images/ethincities.png') }}">
                                <span class="sidenav-normal  ms-2  ps-1">Ethnicities</span>
                            </a>
                        </li>
                        <li class="nav-item {{isActive('questions.faith.list')}}">
                            <a class="nav-link text-white {{isActive('questions.faith.list')}}" href="{{route('questions.faith.list')}}">
                                <img class="menu-img-class" src="{{ asset('images/faith.png') }}">
                                <span class="sidenav-normal  ms-2  ps-1">Faiths</span>
                            </a>
                        </li>
                        <li class="nav-item {{isActive('questions.gender.list')}}">
                            <a class="nav-link text-white {{isActive('questions.gender.list')}}" href="{{route('questions.gender.list')}}">
                                <img class="menu-img-class" src="{{ asset('images/genders.png') }}">
                                <span class="sidenav-normal  ms-2  ps-1">Genders</span>
                            </a>
                        </li>
                        <li class="nav-item {{isActive('questions.height.list')}}">
                            <a class="nav-link text-white {{isActive('questions.height.list')}}" href="{{route('questions.height.list')}}">
                                <img class="menu-img-class" src="{{ asset('images/height.png') }}">
                                <span class="sidenav-normal  ms-2  ps-1">Heights</span>
                            </a>
                        </li>
                        <li class="nav-item {{isActive('questions.hobby.list')}}">
                            <a class="nav-link text-white {{isActive('questions.hobby.list')}}" href="{{route('questions.hobby.list')}}">
                                <img class="menu-img-class" src="{{ asset('images/hobbies.png') }}">
                                <span class="sidenav-normal  ms-2  ps-1">Hobbies</span>
                            </a>
                        </li>
                        <li class="nav-item {{isActive('questions.icebreaker.list')}}">
                            <a class="nav-link text-white {{isActive('questions.icebreaker.list')}}" href="{{route('questions.icebreaker.list')}}">
                                <img class="menu-img-class" src="{{ asset('images/ice-breaker.png') }}">
                                <span class="sidenav-normal  ms-2  ps-1">Ice Breakers</span>
                            </a>
                        </li>
                        <li class="nav-item {{isActive('questions.industry.list')}}">
                            <a class="nav-link text-white {{isActive('questions.industry.list')}}" href="{{route('questions.industry.list')}}">
                                <img class="menu-img-class" src="{{ asset('images/industry.png') }}">
                                <span class="sidenav-normal  ms-2  ps-1">Industries</span>
                            </a>
                        </li>
                        <li class="nav-item {{isActive('questions.question.list')}}">
                            <a class="nav-link text-white {{isActive('questions.question.list')}}" href="{{route('questions.question.list')}}">
                                <img class="menu-img-class" src="{{ asset('images/question.png') }}">
                                <span class="sidenav-normal  ms-2  ps-1">Questions</span>
                            </a>
                        </li>
                        <li class="nav-item {{isActive('questions.salary.list')}}">
                            <a class="nav-link text-white {{isActive('questions.salary.list')}}" href="{{route('questions.salary.list')}}">
                                <img class="menu-img-class" src="{{ asset('images/salary.png') }}">
                                <span class="sidenav-normal  ms-2  ps-1">Salaries</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#users_menu" class="nav-link text-white {{ isActivePrefix('users','active') }}" aria-controls="users_menu" role="button" aria-expanded="{{ isActivePrefix('users','true') }}">
                    <i class="material-icons-round opacity-10">group</i>
                    <span class="nav-link-text ms-2 ps-1">Users</span>
                </a>
                <div class="collapse {{ isActivePrefix('users','show') }}" id="users_menu">
                    <ul class="nav ">
                        <!-- <li class="nav-item {{ isActive('users.list') }}">
                            <a class="nav-link text-white {{ isActive('users.list') }}" href="{{route('users.list')}}">
                                <i class="material-icons opacity-10">person_add</i>
                                <span class="sidenav-normal  ms-2  ps-1">Add User</span>
                            </a>
                        </li> -->
                        <li class="nav-item {{isActive('users.list')}}">
                            <a class="nav-link text-white {{isActive('users.list')}}" href="{{route('users.list')}}">
                                <i class="material-icons opacity-10">list_alt</i>
                                <span class="sidenav-normal  ms-2  ps-1">List</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</aside>