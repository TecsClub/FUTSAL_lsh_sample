import { Component, ViewChild, AfterViewInit, ViewEncapsulation } from '@angular/core';

import { jqxDropDownButtonComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxdropdownbutton';
import { jqxTreeComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxtree';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.css'],
    encapsulation: ViewEncapsulation.None
})

export class AppComponent implements AfterViewInit {
    @ViewChild('myDropDownButton') myDropDownButton: jqxDropDownButtonComponent;
    @ViewChild('myTree') myTree: jqxTreeComponent;

    ngAfterViewInit(): void {
        this.myDropDownButton.setContent('<div style="position: relative; margin-left: 3px; margin-top: 4px;">Home</div>');
    }
   
    treeOnSelect(event: any): void {
        let item = this.myTree.getItem(event.args.element);
        let dropDownContent = `<div style="position: relative; margin-left: 3px; margin-top: 4px;">${item.label}</div>`;
        this.myDropDownButton.setContent(dropDownContent);
    }

    checkBoxOnChange(event: any): void {
        this.myDropDownButton.autoOpen(event.args.checked);
    }
}
