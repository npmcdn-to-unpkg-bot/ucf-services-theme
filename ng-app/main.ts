import { bootstrap } from "@angular/platform-browser-dynamic";
import { disableDeprecatedForms, provideForms } from "@angular/forms";
import { HTTP_PROVIDERS } from "@angular/http";
import "rxjs/Rx";   // Load all features

import { SearchService } from "./app-student-services/search/service/search.service";
import { CalendarService } from "./calendar/calendar.service";
// import { SearchFormComponent } from "./app-student-services/search/search-form.component";
// import { SearchResultsComponent } from "./app-student-services/search/search-results.component";

import { AppStudentServicesComponent } from "./app-student-services/app-student-services.component";

// bootstrap( SearchResultsComponent, [ HTTP_PROVIDERS, SearchService ] )
//  .catch(err => console.error(err) );

// bootstrap( SearchFormComponent, [ SearchService ] )
//  .catch(err => console.error(err) );

bootstrap( AppStudentServicesComponent , [
        disableDeprecatedForms(), provideForms(), HTTP_PROVIDERS, SearchService, CalendarService,
    ] )
    .then( ( comp_ref ) => {
        window.ucf_app_comp_ref = comp_ref;
        window.ucf_app_instance = comp_ref.instance;
        // window.ucf_app_instance = window.ng.probe( document.getElementsByTagName('ucf-app-student-services'[0] ).componentInstance;
    })
    .catch( err => console.error(err) );
