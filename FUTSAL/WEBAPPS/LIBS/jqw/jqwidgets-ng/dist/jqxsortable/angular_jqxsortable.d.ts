/// <reference path="../jqwidgets.d.ts" />
import { EventEmitter, ElementRef, OnChanges, SimpleChanges } from '@angular/core';
export declare class jqxSortableComponent implements OnChanges {
    attrAppendTo: string;
    attrAxis: number | string;
    attrCancel: string;
    attrConnectWith: string | boolean;
    attrContainment: string | boolean;
    attrCursor: string;
    attrCursorAt: jqwidgets.SortableCursorAt;
    attrDelay: number;
    attrDisabled: boolean;
    attrDistance: number;
    attrDropOnEmpty: boolean;
    attrForceHelperSize: boolean;
    attrForcePlaceholderSize: boolean;
    attrGrid: Array<number>;
    attrHandle: string | boolean;
    attrHelper: (originalEvent?: any, content?: any) => void | 'original' | 'clone';
    attrItems: string;
    attrOpacity: number | boolean;
    attrPlaceholderShow: string | boolean;
    attrRevert: number | boolean;
    attrScroll: boolean;
    attrScrollSensitivity: number;
    attrScrollSpeed: number;
    attrTolerance: string;
    attrZIndex: number;
    attrWidth: string | number;
    attrHeight: string | number;
    autoCreate: boolean;
    properties: string[];
    host: any;
    elementRef: ElementRef;
    widgetObject: jqwidgets.jqxSortable;
    constructor(containerElement: ElementRef);
    ngOnInit(): void;
    ngOnChanges(changes: SimpleChanges): boolean;
    arraysEqual(attrValue: any, hostValue: any): boolean;
    manageAttributes(): any;
    moveClasses(parentEl: HTMLElement, childEl: HTMLElement): void;
    moveStyles(parentEl: HTMLElement, childEl: HTMLElement): void;
    createComponent(options?: any): void;
    createWidget(options?: any): void;
    __updateRect__(): void;
    setOptions(options: any): void;
    appendTo(arg?: string): string;
    axis(arg?: number | string): number | string;
    cancel(arg?: string): string;
    connectWith(arg?: string | boolean): string | boolean;
    containment(arg?: string | boolean): string | boolean;
    cursor(arg?: string): string;
    cursorAt(arg?: jqwidgets.SortableCursorAt): jqwidgets.SortableCursorAt;
    delay(arg?: number): number;
    disabled(arg?: boolean): boolean;
    distance(arg?: number): number;
    dropOnEmpty(arg?: boolean): boolean;
    forceHelperSize(arg?: boolean): boolean;
    forcePlaceholderSize(arg?: boolean): boolean;
    grid(arg?: Array<number>): Array<number>;
    handle(arg?: string | boolean): string | boolean;
    helper(arg?: (originalEvent?: any, content?: any) => void | 'original' | 'clone'): (originalEvent?: any, content?: any) => void | 'original' | 'clone';
    items(arg?: string): string;
    opacity(arg?: number | boolean): number | boolean;
    placeholderShow(arg?: string | boolean): string | boolean;
    revert(arg?: number | boolean): number | boolean;
    scroll(arg?: boolean): boolean;
    scrollSensitivity(arg?: number): number;
    scrollSpeed(arg?: number): number;
    tolerance(arg?: string): string;
    zIndex(arg?: number): number;
    cancelMethod(): void;
    destroy(): void;
    disable(): void;
    enable(): void;
    refresh(): void;
    refreshPositions(): void;
    serialize(object: undefined): string;
    toArray(): Array<any>;
    onActivate: EventEmitter<{}>;
    onBeforeStop: EventEmitter<{}>;
    onChange: EventEmitter<{}>;
    onDeactivate: EventEmitter<{}>;
    onOut: EventEmitter<{}>;
    onOver: EventEmitter<{}>;
    onReceive: EventEmitter<{}>;
    onRemove: EventEmitter<{}>;
    onSort: EventEmitter<{}>;
    onStart: EventEmitter<{}>;
    onStop: EventEmitter<{}>;
    onUpdate: EventEmitter<{}>;
    __wireEvents__(): void;
}
