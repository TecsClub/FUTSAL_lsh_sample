import { Component, ViewChild, AfterViewInit, ElementRef } from '@angular/core';

import { jqxMenuComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxmenu';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html'
})

export class AppComponent implements AfterViewInit {
    @ViewChild('jqxMenu') jqxMenu: jqxMenuComponent;
    @ViewChild('log') log: ElementRef;

    ngAfterViewInit() {
        this.jqxMenu.focus();
    }
	
	getWidth() : any {
		if (document.body.offsetWidth < 600) {
			return '90%';
		}
		
		return 600;
	}
	
    itemclick(event: any): void {
        this.log.nativeElement.innerHTML = "Clicked: " + event.args.innerText;
    };
}