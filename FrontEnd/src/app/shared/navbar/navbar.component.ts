import { Component, OnInit, Renderer, ViewChild, ElementRef } from '@angular/core';
import { ROUTES } from '../../sidebar/sidebar.component';
import { Router, ActivatedRoute } from '@angular/router';
import { Location, LocationStrategy, PathLocationStrategy } from '@angular/common';

@Component({
    moduleId: module.id,
    selector: 'navbar-cmp',
    templateUrl: 'navbar.component.html'
})

export class NavbarComponent implements OnInit {
    private listTitles: any[];
    location: Location;
    private nativeElement: Node;
    private toggleButton;
    private sidebarVisible: boolean;
    basePath = '#';
    baseTitle = '';

    @ViewChild('navbar-cmp') button;

    constructor(location: Location, private renderer: Renderer, private element: ElementRef) {
        this.location = location;
        this.nativeElement = element.nativeElement;
        this.sidebarVisible = false;
    }

    ngOnInit() {
        this.listTitles = ROUTES.filter(listTitle => listTitle);
        const navbar: HTMLElement = this.element.nativeElement;
        this.toggleButton = navbar.getElementsByClassName('navbar-toggle')[0];
        this.baseTitle = this.getTitle();
    }

    getRootPath() {
        const path = window.location.pathname.substring(1);
        this.basePath = path.substring(0, path.indexOf('/') !== -1 ? path.indexOf('/') : path.length);
        return '/' + this.basePath;
    }

    getTitle() {
        const titlee = window.location.pathname;
        for (let item = 0; item < this.listTitles.length; item++) {
            if (this.listTitles[item].path === titlee) {
                return this.listTitles[item].title;
            } else if (titlee.indexOf(this.listTitles[item].path) !== -1 ) {
                return this.listTitles[item].title;
            }
        }
        return 'Dashboard';
    }
    sidebarToggle() {
        const toggleButton = this.toggleButton;
        const body = document.getElementsByTagName('body')[0];

        if (this.sidebarVisible === false) {
            setTimeout(function(){
                toggleButton.classList.add('toggled');
            }, 500);
            body.classList.add('nav-open');
            this.sidebarVisible = true;
        } else {
            this.toggleButton.classList.remove('toggled');
            this.sidebarVisible = false;
            body.classList.remove('nav-open');
        }
    }
}
