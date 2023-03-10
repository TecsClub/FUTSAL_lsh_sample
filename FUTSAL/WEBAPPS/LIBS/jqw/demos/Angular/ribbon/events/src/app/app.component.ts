import { Component, ViewChild, ViewEncapsulation } from '@angular/core';

import { jqxPanelComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxpanel';

@Component({
    selector: 'app-root',
    styleUrls: ['./app.component.css'],
    templateUrl: './app.component.html',
    encapsulation: ViewEncapsulation.None
})

export class AppComponent {
    @ViewChild('log') log: jqxPanelComponent;

    select(event: any): void {
        let args = event.args;
        let selectedIndex = event.args.selectedIndex;
        this.log.prepend('<div style="margin-top: 5px;">Selected: ' + selectedIndex + '</div>');
    };

    unselect(event: any): void {
        let args = event.args;
        let unselectedIndex = event.args.unselectedIndex;
        this.log.prepend('<div style="margin-top: 5px;">Unselected: ' + unselectedIndex  + '</div>');
    };
}