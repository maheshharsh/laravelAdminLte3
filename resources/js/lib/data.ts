export type MailboxStatus = 'active' | 'backup' | 'disabled';

export interface Mailbox {
    bounce: number;
    created: boolean;
    created_at: string;
    domain_id: string;
    forward_to: string[];
    id: string;
    name: string;
    received: number;
    sent: number;
    status: 'active' | 'backup' | 'disabled';
    domain_name: string;
    title: string;
    updated_at: string;
    user_id: string;
    profile_image: string | null;
}

export interface Batch {
    id: string;
    status: string;
    title: string;
    completed: boolean;
    sequencer: string;
    dateCreated: string;
    mailboxAmount: number;
    primaryDomains: number;
    backupDomains: number;
}
