

@if(Auth::check())
    <form-crowdfunding :is-logged-in='true' :user='@json(Auth::user())'></form-crowdfunding>
@else

    <form-crowdfunding ></form-crowdfunding>
    <p>Per favore, accedi per effettuare una donazione.</p>
@endif
