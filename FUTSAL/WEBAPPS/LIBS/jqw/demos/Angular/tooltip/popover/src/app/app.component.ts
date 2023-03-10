import { Component, ViewChild, ViewEncapsulation } from '@angular/core';

import { jqxTooltipComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxtooltip';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styles: [`
        jqxTooltip div {
            height: 162px;
        }
    `],
    encapsulation: ViewEncapsulation.None
})

export class AppComponent {
    @ViewChild('filmPicture1') myTooltip: jqxTooltipComponent;

    toggle: boolean = false;

    click(): void {
        if (this.toggle == false) {
            this.myTooltip.open();
            this.toggle = true;
        } else {
            this.myTooltip.close();
            this.toggle = false;
        }
    };
}