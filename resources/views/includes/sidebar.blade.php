<h1>
    Makisig <span>Rescue</span><br><span>3121</span>
</h1>
<ul>
    <li class="{{ (Request::route()->getName() == "") ? 'active' : '' }}"><a href="/"><span class="fas fa-tachometer-alt"></span>Dasboard<span class="fas fa-caret-right"></span></a></li>
    <li class="{{ (Request::route()->getName() == "citizens") ? 'active' : '' }}"><a href="/citizens"><span class="fas fa-id-badge"></span>Citizens<span class="fas fa-caret-right"></span></a></li>
    <li class="{{ (Request::route()->getName() == "rescuers") ? 'active' : '' }}"><a href="/rescuers"><span class="fas fa-user-shield"></span>Rescuers<span class="fas fa-caret-right"></span></a></li>
    <li class="{{ (Request::route()->getName() == "accidents") ? 'active' : '' }}"><a href="/accidents"><span class="fas fa-ambulance"></span>Accidents<span class="fas fa-caret-right"></span></a></li>
    <li class="{{ (Request::route()->getName() == "items") ? 'active' : '' }}"><a href="/items"><span class="fas fa-file-alt"></span>Items Recovered<span class="fas fa-caret-right"></span></a></li>
    <li class="{{ (Request::route()->getName() == "analytics") ? 'active' : '' }}"><a href="/analytics"><span class="fas fa-chart-bar"></span>Data Analysis<span class="fas fa-caret-right"></span></a></li>
    <li class="{{ (Request::route()->getName() == "map") ? 'active' : '' }}"><a href="/map"><span class="fas fa-map-marked-alt"></span>Map<span class="fas fa-caret-right"></span></a>
    
    <li class="{{ (Request::route()->getName() == "messages") ? 'active' : '' }}"><a href="/messages"><span class="fas fa-comment-alt"></span>Messages<span class="fas fa-caret-right"></span></a></li>

    <li class="{{ (Request::route()->getName() == "mobile-users") ? 'active' : '' }}"><a href="/mobile-users"><span class="fas fa-users"></span>Mobile Users<span class="fas fa-caret-right"></span></a></li>
</ul>
