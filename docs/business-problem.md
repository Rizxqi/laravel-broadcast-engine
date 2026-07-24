# 💼 Business Problem

## The Problem

Before this system existed, several operational issues affected audio management across building zones:

- No centralized control for audio across multiple zones/areas of a building
- Music management was done manually (e.g., plugging in a flash drive, physically adjusting volume per zone)
- No easy way to change a playlist or add a song without physical access to the device
- No way to monitor whether audio was actually playing in a given zone
- Difficult to manage access — who is allowed to change the playlist for which zone

## Previous Condition

Audio was managed manually — likely through a physical device (a PC/laptop directly connected to an amplifier/speaker) or a standalone music player per zone. There was no centralized, network-based system.

## Key Operational Needs

The following capabilities were the most important for operators:

| Need | Description |
|---|---|
| **Playlist management** | Create, edit, delete playlists per zone/channel |
| **Song upload** | Add audio content (MP3/MP4) directly from the browser |
| **Stream monitoring** | Know whether a zone is currently streaming or offline |
| **Role-based access** | Restrict who can edit which playlist |
| **Automatic streaming** | Once set up, audio runs on its own without ongoing manual intervention |

## Impact if Unresolved

- Audio zones could go silent with no one aware of it (no monitoring)
- Content became outdated because it was hard to update remotely
- High risk of human error (wrong playlist, wrong zone)
- High operational cost due to needing physical staff to manage each zone
- No audit trail of who changed what

## Proposed Solution

The system provides a centralized web dashboard accessible from anywhere on the network. Operators simply upload a song → create a playlist → assign songs to the playlist → the system automatically generates the Liquidsoap configuration and starts streaming directly via Icecast. Real-time status monitoring (online/offline) is available on the dashboard, and RBAC ensures each operator can only manage the zones/playlists they are responsible for.
