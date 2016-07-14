import { Component, ElementRef, OnInit, OnChanges,
    Input, EventEmitter } from "@angular/core";
import { HTTP_PROVIDERS } from "@angular/http";
import "rxjs/Rx";   // Load all features

import { SearchFormComponent } from "./search-form.component";
import { SearchResultsComponent } from "./search-results.component";
import { SearchService } from "./search.service";
import { IStudentService } from "./studentservice.interface";

@Component({
    selector: "ucf-app-student-services",
    moduleId: module.id,
    // template: `${window.ucfAppStudentServices}`, // http://stackoverflow.com/questions/32568808/angular2-root-component-with-ng-content
    templateUrl: "./app-student-services.component.html",
    directives: [ SearchFormComponent, SearchResultsComponent ],
})
export class AppStudentServicesComponent {
    @Input() api: string;
    @Input() title: string = "Student Services";
    query: string = "";

    // Can't use @Input() (or ng-content) with a root Angular2 element.
    // http://stackoverflow.com/a/33641842 and https://github.com/angular/angular/issues/1858#issuecomment-137696843
    // http://stackoverflow.com/a/32574733
    constructor( public elementRef: ElementRef, protected _searchService: SearchService ) {
        let native = this.elementRef.nativeElement;
        this.api = native.getAttribute("[api]");
        this.title = native.getAttribute("[title]");
    }


    onSearchChanged( newSearch: Event ): void {
        this.query = newSearch.target.value;
    }

    ngOnInit(): void { }

    ngOnChanges(): void { }
}
