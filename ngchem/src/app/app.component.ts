import { Component, Input, OnInit } from '@angular/core';
import { SessionManagerService } from './core/session-manager.service';
import { LogService } from './core/log.service';
import { User } from './core/user';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  title = 'app works!';
  user: User;
  errorMessage: any;

  constructor(private sessionManagerService: SessionManagerService, private logService: LogService) {}

  ngOnInit(): void {
    this.logService.getUser().subscribe(
                     user => this.user = user,
                     error =>  this.errorMessage = <any>error
                   );
  }

}
